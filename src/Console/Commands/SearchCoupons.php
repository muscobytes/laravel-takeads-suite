<?php

namespace Muscobytes\Laravel\Takeads\Suite\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Muscobytes\Laravel\Takeads\Suite\Models\Category;
use Muscobytes\Laravel\Takeads\Suite\Models\Country;
use Muscobytes\Laravel\Takeads\Suite\Models\Coupon;
use Muscobytes\Laravel\Takeads\Suite\Models\Language;
use Muscobytes\Laravel\Takeads\Suite\Models\Merchant;
use Muscobytes\Laravel\TakeadsApi\TakeadsApi;
use Muscobytes\Laravel\TraitsCollection\Console\Command\TableFormatter;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V1\CouponSearch\CouponDto;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V1\CouponSearch\CouponSearchDto;
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V1\CouponSearch\CouponSearchRequestParameters;

class SearchCoupons extends Command implements PromptsForMissingInput
{
    use TableFormatter;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ta:coupons:search {uri} {--languages=} {--categories=} {--subid=} {--dry}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search for coupons in the Takeads API';


    /**
     * Execute the console command.
     */
    public function handle(TakeadsApi $api): void
    {
        try {
            $response = $api->couponSearch(
                env('TAKEADS_PLATFORM_ID'),
                CouponSearchRequestParameters::fromArray([
                    'iris' => [
                        $this->argument('uri')
                    ],
                    'languageCodes' => $this->option('languages')
                        ? explode(',', $this->option('languages'))
                        : null,
                    'categoryIds' => $this->option('categories')
                        ? array_map(
                            fn ($categoryId) => (int) $categoryId,
                            explode(',', $this->option('categories')))
                        : null,
                    'subId' => $this->option('subid') ?? null
                ])
            );
            /** @var CouponSearchDto $iri */
            foreach ($response->getPayload() as $iri) {
                /** @var CouponDto $coupon */
                foreach ($iri->coupons as $couponDto) {
                    $this->info(
                        $this->formatRow(
                            [
                                $couponDto->couponId,
                                $couponDto->code,
                                $couponDto->name,
                                implode(',', $couponDto->languageCodes),
                                implode(',', $couponDto->countryCodes),
                                implode(',', $couponDto->categoryIds)
                            ],
                            [ 24, 12, 60, 10, 25 ]
                        )
                    );
                    if (!$this->option('dry')) {
                        Coupon::updateOrCreateFromDto($couponDto);
                    }
                }
            }
        } catch (Exception $e) {
            $this->info($e->getMessage());
        }
    }
}
