<?php

namespace Muscobytes\Laravel\Takeads\Coupons\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Muscobytes\Laravel\Takeads\Coupons\Models\TakeadsCategory;
use Muscobytes\Laravel\Takeads\Coupons\Models\TakeadsCountry;
use Muscobytes\Laravel\Takeads\Coupons\Models\TakeadsCoupon;
use Muscobytes\Laravel\Takeads\Coupons\Models\TakeadsLanguage;
use Muscobytes\Laravel\Takeads\Coupons\Models\TakeadsMerchant;
use Muscobytes\Laravel\Takeads\Coupons\Traits\Command\TableFormatter;
use Muscobytes\Laravel\TakeadsApi\TakeadsApi;
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
                foreach ($iri->coupons as $coupon) {
                    $this->info(
                        $this->formatRow(
                            [
                                $coupon->couponId,
                                $coupon->code,
                                $coupon->name,
                                implode(',', $coupon->languageCodes),
                                implode(',', $coupon->countryCodes),
                                implode(',', $coupon->categoryIds)
                            ],
                            [ 24, 12, 60, 10, 25 ]
                        )
                    );
                    if (!$this->option('dry')) {
                        $taCoupon = TakeadsCoupon::updateOrCreate([
                            'external_id' => $coupon->couponId
                        ], [
                            'is_active' => true,
                            'tracking_link' => $coupon->trackingLink,
                            'name' => $coupon->name,
                            'code' => $coupon->code,
                            'merchant_id' => TakeadsMerchant::firstOrCreate([
                                'external_id' => $coupon->merchantId
                            ], [
                                'is_active' => true,
                            ])->id,
                            'image_uri' => $coupon->imageUri,
                            'start_date' => $coupon->startDate,
                            'end_date' => $coupon->endDate,
                            'description' => $coupon->description,
                        ]);

                        $taCoupon->languages()->attach(array_map(
                            fn ($languageCode) => TakeadsLanguage::firstOrCreate([
                                'code' => $languageCode
                            ])->id,
                            $coupon->languageCodes
                        ));

                        $taCoupon->countries()->attach(array_map(
                            fn ($countryId) => TakeadsCountry::firstOrCreate([
                                'code' => $countryId
                            ])->id,
                            $coupon->countryCodes
                        ));

                        $taCoupon->categories()->attach(array_map(
                            fn ($categoryId) => TakeadsCategory::firstOrCreate([
                                'external_id' => $categoryId
                            ])->id,
                            $coupon->categoryIds
                        ));
                    }
                }
            }
        } catch (Exception $e) {
            $this->info($e->getMessage());
        }
    }
}
