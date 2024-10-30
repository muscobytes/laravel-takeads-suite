<?php

namespace Muscobytes\Laravel\Takeads\Suite\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Muscobytes\Laravel\Takeads\Suite\Models\Category;
use Muscobytes\Laravel\Takeads\Suite\Models\Country;
use Muscobytes\Laravel\Takeads\Suite\Models\Currency;
use Muscobytes\Laravel\Takeads\Suite\Models\Merchant;
use Muscobytes\Laravel\TakeadsApi\TakeadsApi;
use Muscobytes\Laravel\TraitsCollection\Console\Command\TableFormatter;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V2\Merchant\MerchantDto;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V2\Merchant\MerchantRequestParameters;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V2\Merchant\MerchantResponse;

class ImportMerchants extends Command implements PromptsForMissingInput
{
    use TableFormatter;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ta:merchants:import
        {--next= : The ID of the next merchant to start importing from. If omitted, imports will start from the beginning. }
        {--limit=500 : Number of records to fetch per page. }
        {--stop-after-limit : Stop the import process after fetching the specified limit of records, without retrieving subsequent pages. }
        {--status= : Filter merchants by their status. Acceptable values are "active" or "inactive". }
        {--updatedAtFrom= : Only import merchants that have been updated after the specified date (in YYYY-MM-DD format). }
        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import merchants';


    public function getIsActive()
    {
        $result = null;
        if ($this->option('status')) {
            $allowedStatuses = [
                'active' => true,
                'inactive' => false
            ];
            if (!key_exists($this->option('status'), $allowedStatuses)) {
                $this->error('Invalid status: possible values ' . implode(',', $allowedStatuses));
                exit(1);
            }
            $result = $allowedStatuses[$this->option('status')];
        }
        return $result;
    }


    /**
     * Execute the console command.
     */
    public function handle(TakeadsApi $api): void
    {

        try {
            $responses = $api->merchant(
                env('TAKEADS_PLATFORM_ID'),
                MerchantRequestParameters::fromArray([
                    'next' => $this->option('next'),
                    'limit' => $this->option('limit'),
                    'updatedAtFrom' => $this->option('updatedAtFrom'),
                    'isActive' => $this->getIsActive(),
                ]),
            );
            /** @var MerchantResponse $response */
            foreach ($responses as $response) {
                /** @var MerchantDto $merchant */
                foreach ($response->getPayload() as $merchant) {
                    $this->info(
                        $this->formatRow(
                            [
                                $merchant->merchantId,
                                $merchant->name,
                                $merchant->defaultDomain
                            ],
                            [ 12, 40, 30 ]
                        )
                    );
                    $taMerchant = Merchant::updateOrCreate(
                        [
                            'external_id' => $merchant->merchantId
                        ],
                        [
                            'name' => $merchant->name,
                            'image_uri' => $merchant->imageUri,
                            'currency_id' => Currency::firstOrCreate([
                                'code' => $merchant->currencyCode
                            ])->id,
                            'default_domain' => $merchant->defaultDomain,
                            'domains' => json_encode($merchant->domains),
                            'category_id' => is_null($merchant->categoryId) ? null : Category::firstOrCreate([
                                'external_id' => $merchant->categoryId
                            ])->id,
                            'description' => $merchant->description,
                            'is_active' => $merchant->isActive,
                            'tracking_link' => $merchant->trackingLink,
                        ]
                    );
                    $taMerchant->countries()->attach(array_map(
                        function($countryCode) {
                            return Country::firstOrCreate(['code' => $countryCode])->id;
                        },
                        $merchant->countryCodes
                    ));
                }

                if ($this->option('stop-after-limit')) {
                    break;
                }
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
