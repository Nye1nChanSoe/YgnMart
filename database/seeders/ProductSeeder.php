<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private array $foods = [
        'Delicious Crunch Apples from GreenGrove, USA',
        'Tropical Delight Bananas from SunnyHarvest, Costa Rica',
        'Zesty Citrus Oranges from Nature\'s Best, Spain',
        'Creamy Dairy Milk from DairyDelights, New Zealand',
        'Farm-Fresh Eggs from HappyHen Farms, Canada',
        'Artisanal Baker\'s Bread from GoldenGrains, France',
        'Tender & Tasty Chicken from TenderFarm, Brazil',
        'Premium Choice Beef from PrimeCuts, Argentina',
        'Fresh Catch Fish from OceanBounty, Norway',
        'Fragrant Basmati Rice from SpiceLand, India',
        'Locally Grown Potatoes from FarmHarvest, Ireland',
        'Vine-Ripe Tomatoes from GardenFresh, Italy',
        'Crisp Garden Lettuce from FreshField, Australia',
        'Cool Cucumbers from GreenPatch, Netherlands',
        'Sweet Carrots from SunnyFields, Belgium',
        'Flavorful Onions from SpiceTrail, Egypt',
        'Artisan Cheese Selection from DairyHeritage, Switzerland',
        'Creamy Greek Yogurt from PureBliss, Greece',
        'Rich and Creamy Butter from GoldenGlow, Denmark',
        'Extra Virgin Olive Oil from OliveGrove, Greece',
        'Delicious Pasta Varieties from BellaItalia, Italy',
        'Wholesome Granola Cereal from MorningDelight, USA',
        'Hearty Steel-Cut Oatmeal from CountryHarvest, Canada',
        'Savory Soup Mix from Chef\'sChoice, France',
        'Tasty Canned Beans from HarvestGoodness, Mexico',
        'Garden-Fresh Frozen Peas from SnowPeak, Norway',
        'Premium Arabica Coffee from JavaBean, Colombia',
        'Finest Tea Selection from RoyalTea, England',
        'Pure Cane Sugar from SweetHarmony, Brazil',
        'Gourmet Sea Salt from SaltEssentials, France',

        // Meats
        'Tender Pork Chops from SavoryCuts, USA',
        'Flavorful Ground Beef from GourmetGrind, Australia',
        'Juicy Grilled Chicken Breasts from FireFlame, Brazil',
        'Premium Smoked Bacon from HeavenlyHog, Canada',
        'Succulent Lamb Chops from MeadowMist, New Zealand',
        'Delicious Turkey Sausages from HerbSeasoned, Italy',
        'Savory BBQ Ribs from GrillMaster, USA',
        'Tasty Beef Jerky from SnackAttack, USA',
        'Gourmet Duck Breast from ArtisanRoast, France',
        'Tender Veal Cutlets from PastureRaised, Argentina',

        // Snacks
        'Crunchy Potato Chips from SnackCrave, USA',
        'Irresistible Chocolate Bars from SweetIndulgence, Switzerland',
        'Nutritious Trail Mix from Nature\'sTrail, Canada',
        'Cheesy Popcorn from PoppedPerfection, USA',
        'Wholesome Granola Bars from Nature\'sFuel, Australia',
        'Flavorful Pretzels from TwistyCrunch, Germany',
        'Delightful Fruit Snacks from FreshBurst, Spain',
        'Sweet and Salty Nuts from NuttyDelight, Brazil',
        'Tangy Pickles from CrispCrunch, USA',
        'Crispy Rice Crackers from CrunchyBites, Japan',
        'Rich Chocolate Spread from ChocoBliss, Belgium',
        'Smooth Peanut Butter from CreamyCrunch, USA',
        'Natural Honey from SweetHarvest, Canada',
        'Creamy Mayonnaise from WhiskDelight, France',
        'Spicy Sriracha Sauce from FireFlame, Thailand',
        'Classic Ketchup from TomatoTang, USA',
        'Zesty Barbecue Sauce from GrillMaster, USA',
        'Flavorful Taco Seasoning from SpiceMix, Mexico',
        'Authentic Curry Paste from ExoticSpice, India',
        'Versatile Olive Tapenade from MediterraneanDelights, Greece',

        // Vegetables
        'Crisp Asparagus Spears from FreshHarvest, Peru',
        'Sweet Corn on the Cob from GoldenFields, USA',
        'Fresh Green Beans from TenderCrop, Mexico',
        'Colorful Bell Peppers from HarvestRainbow, Netherlands',
        'Tender Broccoli Florets from GardenFresh, Spain',
        'Vibrant Spinach Leaves from LeafyGreen, Italy',
        'Juicy Grape Tomatoes from VineSweet, USA',
        'Flavorful Mushrooms from ForestHarvest, Canada',
        'Crunchy Celery Stalks from GardenGrown, France',
        'Hearty Butternut Squash from HarvestGold, Australia',

        // pantry 
        'Fragrant Basmati Rice from ScentedHarvest, India',
        'Authentic Italian Pasta from BellaFresco, Italy',
        'Premium All-Purpose Flour from GourmetBlend, USA',
        'Hand-Harvested Sea Salt from SaltySeas, France',
        'Extra Virgin Olive Oil from OlivaLuxe, Greece',
        'Sun-Ripened Canned Tomatoes from VineFresh, Italy',
        'Exotic Spice Blend from FlavorfulJourney, Morocco',
        'Tender Black Beans from SavoryLegumes, Mexico',
        'Crunchy Whole Grain Cereal from NutriCrave, USA',
    ];

    private array $foodCategories = [
        ['fruits', 'apples'],                                // Delicious Crunch Apples
        ['fruits', 'bananas'],                                // Tropical Delight Bananas
        ['fruits', 'oranges'],                                // Zesty Citrus Oranges
        ['dairy', 'milk'],                                 // Creamy Dairy Milk
        ['eggs'],                                  // Farm-Fresh Eggs
        ['breads'],                                // Artisanal Baker's Bread
        ['meats', 'chicken'],                       // Tender & Tasty Chicken
        ['meats', 'beef'],                          // Premium Choice Beef
        ['seafood', 'fish'],                       // Fresh Catch Fish
        ['grains', 'rice'],                        // Fragrant Basmati Rice
        ['vegetables', 'potatoes'],                // Locally Grown Potatoes
        ['vegetables', 'tomatoes'],                // Vine-Ripe Tomatoes
        ['vegetables', 'lettuce'],                 // Crisp Garden Lettuce
        ['vegetables', 'cucumbers'],               // Cool Cucumbers
        ['vegetables', 'carrots'],                 // Sweet Carrots
        ['vegetables', 'onions'],                  // Flavorful Onions
        ['dairy', 'cheese'],                        // Artisan Cheese Selection
        ['dairy', 'yogurt'],                        // Creamy Greek Yogurt
        ['dairy', 'butter'],                        // Rich and Creamy Butter
        ['condiments', 'oil'],                      // Extra Virgin Olive Oil
        ['grains', 'pasta'],                         // Delicious Pasta Varieties
        ['breakfast', 'cereal'],                     // Wholesome Granola Cereal
        ['breakfast', 'oatmeal'],                    // Hearty Steel-Cut Oatmeal
        ['condiments', 'soup mix'],                  // Savory Soup Mix
        ['canned goods', 'beans'],                    // Tasty Canned Beans
        ['frozen foods', 'peas'],                      // Garden-Fresh Frozen Peas
        ['beverages', 'coffee'],                       // Premium Arabica Coffee
        ['beverages', 'tea'],                          // Finest Tea Selection
        ['sugar'],                                      // Pure Cane Sugar
        ['condiments', 'salt'],                         // Gourmet Sea Salt
    
        // meatss
        ['meats', 'pork'],                                // Tender Pork Chops
        ['meats', 'beef'],                                // Flavorful Ground Beef
        ['meats', 'chicken'],                             // Juicy Grilled Chicken Breasts
        ['meats', 'pork'],                                 // Premium Smoked Bacon
        ['meats', 'lamb'],                                 // Succulent Lamb Chops
        ['meats', 'poultry'],                              // Delicious Turkey Sausages
        ['meats', 'ribs'],                                 // Savory BBQ Ribs
        ['snacks', 'jerky'],                              // Tasty Beef Jerky
        ['meats', 'poultry'],                              // Gourmet Duck Breast
        ['meats', 'veal'],                                 // Tender Veal Cutlets

        ['snacks', 'chips'],                                       // Crunchy Potato Chips
        ['snacks', 'chocolate'],                        // Irresistible Chocolate Bars
        ['snacks', 'trail mix'],                         // Nutritious Trail Mix
        ['snacks', 'popcorn'],                           // Cheesy Popcorn
        ['snacks', 'granola bars'],                      // Wholesome Granola Bars
        ['snacks', 'pretzels'],                          // Flavorful Pretzels
        ['snacks', 'fruit snacks'],                       // Delightful Fruit Snacks
        ['snacks', 'nuts'],                               // Sweet and Salty Nuts
        ['snacks', 'pickles'],                            // Tangy Pickles
        ['snacks', 'crackers'],                           // Crispy Rice Crackers
        ['snacks', 'chocolate spread'],                   // Rich Chocolate Spread
        ['snacks', 'peanut butter'],                       // Smooth Peanut Butter
        ['condiments', 'honey'],                           // Natural Honey
        ['condiments', 'mayonnaise'],                      // Creamy Mayonnaise
        ['condiments', 'hot sauce'],                       // Spicy Sriracha Sauce
        ['condiments', 'ketchup'],                          // Classic Ketchup
        ['condiments', 'barbecue sauce'],                    // Zesty Barbecue Sauce
        ['condiments', 'seasoning'],                          // Flavorful Taco Seasoning
        ['condiments', 'curry paste'],                          // Authentic Curry Paste
        ['condiments', 'olive tapenade'],                          // Versatile Olive Tapenade

        // Vegetables
        ['vegetables', 'asparagus'],                                // Crisp Asparagus Spears
        ['vegetables', 'corn'],                                     // Sweet Corn on the Cob
        ['vegetables', 'green beans'],                               // Fresh Green Beans
        ['vegetables', 'bell peppers'],                              // Colorful Bell Peppers
        ['vegetables', 'broccoli'],                                  // Tender Broccoli Florets
        ['vegetables', 'spinach'],                                   // Vibrant Spinach Leaves
        ['vegetables', 'tomatoes'],                                  // Juicy Grape Tomatoes
        ['vegetables', 'mushrooms'],                                 // Flavorful Mushrooms
        ['vegetables', 'celery'],                                    // Crunchy Celery Stalks
        ['vegetables', 'squash'],                                    // Hearty Butternut Squash

        // Staples
        ['pantry', 'rice', 'fragrant-basmati-rice'],
        ['pantry', 'pasta', 'italian-pasta'],
        ['pantry', 'flour', 'all-purpose-flour'],
        ['pantry', 'salt', 'sea-salt'],
        ['pantry', 'olive-oil', 'extra-virgin-olive-oil'],
        ['pantry', 'canned-tomatoes', 'sun-ripened-canned-tomatoes'],
        ['pantry', 'spices', 'exotic-spice-blend'],
        ['pantry', 'beans', 'black-beans'],
        ['pantry', 'cereal', 'whole-grain-cereal'],
    ];

    private array $foodImages = [

    ];

    private array $drinks = [
        // Alcohols
        'Smooth Whiskey from OakBarrel, Scotland',
        'Fine Red Wine from VineyardSelect, France',
        'Refreshing Lager Beer from CraftBrew, Germany',
        'Premium Vodka from CrystalClear, Russia',
        'Aged Rum from CaribbeanSpice, Jamaica',
        'Crisp White Wine from SunnyVineyards, Italy',
        'Craft Gin from BotanicalBlend, England',
        'Rich Tequila from AgaveHarvest, Mexico',
        'Flavorful Craft Beer from HoppyBrews, USA',
        'Soothing Sake from TraditionalBrew, Japan',

        // Soft Drinks
        'Sparkling Cola from FizzBuzz, USA',
        'Zesty Lemon-Lime Soda from CitrusBurst, Australia',
        'Refreshing Orange Fizz from BubblyDelight, Spain',
        'Tropical Pineapple Punch from IslandSplash, Costa Rica',
        'Classic Root Beer from SassafrasBrew, USA',
        'Sweet Strawberry Soda from BerryBlast, France',
        'Exotic Mango Fizz from TropicalTingle, India',
        'Crisp Apple Cider from OrchardFresh, Canada',
        'Bubbly Ginger Ale from SpiceZing, Jamaica',
        'Tangy Grapefruit Soda from CitrusTwist, Mexico',

        // Tea
        'Earl Grey Tea from ClassicInfusion, England',
        'Green Tea with Jasmine from ZenGarden, China',
        'Chamomile Herbal Tea from SereneSip, Germany',
        'Bold English Breakfast Tea from MorningKick, India',
        'Refreshing Peppermint Tea from CoolMint, USA',
        'Fruity Berry Blend Tea from BerryBurst, Canada',
        'Mellow Rooibos Tea from AfricanSunset, South Africa',
        'Elegant Oolong Tea from MountainMist, Taiwan',
        'Invigorating Matcha Green Tea from ZenTaste, Japan',
        'Relaxing Lavender Tea from FragrantBloom, France',

        // Water
        'Purified Spring Water from AquaPure, USA',
        'Refreshing Mineral Water from CrystalSpring, France',
        'Sparkling Water from BubblyBliss, Italy',
        'Natural Coconut Water from TropicalTide, Thailand',
        'Flavored Infused Water from FruitSplash, Australia',
        'Electrolyte Sports Water from ActiveHydrate, Germany',
        'Alkaline Water from PureBalance, Canada',
        'AquaFusion Vitamin Water from HealthyHydration, USA',
        'Artisanal Rose Water from PetalEssence, Morocco',
        'Premium Artesian Water from OasisSprings, Fiji',

        // Milk and Others
        'Organic Whole Milk from HappyCows, USA',
        'Creamy Almond Milk from NuttyNectar, Spain',
        'Rich Chocolate Milk from ChocoBliss, Switzerland',
        'Oat Milk from GrainGoodness, Sweden',
        'Protein-Packed Soy Milk from PowerFuel, Japan',
        'Creamy Cashew Milk from CreamyCrush, Brazil',
        'Classic Condensed Milk from SweetSqueeze, Netherlands',
        'Delicious Coconut Milk from TropicalTwist, Thailand',
        'Creamy Peanut Butter Milkshake from NuttyIndulgence, USA',
        'Energizing Matcha Latte from ZenBlend, Japan'
    ];

    private array $drinksCategories = [
        // Alcohols
        ['alcohols', 'beverages', 'whiskey'],
        ['alcohols', 'beverages'],
        ['alcohols', 'beverages', 'beer', 'refreshing', 'craft'],
        ['alcohols', 'beverages', 'vodka', 'premium'],
        ['alcohols', 'beverages', 'rum', 'aged', 'spice'],
        ['alcohols', 'beverages', 'white wine'],
        ['alcohols', 'beverages', 'gin', 'craft'],
        ['alcohols', 'beverages', 'tequila', 'agave', 'rich'],
        ['alcohols', 'beverages', 'craft beer', 'flavorful'],
        ['alcohols', 'beverages', 'sake', 'soothing', 'traditional'],

        // Soft Drinks
        ['soft drink', 'cola', 'sparkling'],
        ['soft drink', 'lemon-lime soda'],
        ['soft drink', 'orange fizz', 'refreshing'],
        ['soft drink', 'pineapple punch', 'tropical'],
        ['soft drink', 'root beer'],
        ['soft drink', 'strawberry soda'],
        ['soft drink', 'mango fizz', 'exotic'],
        ['soft drink', 'apple cider'],
        ['soft drink', 'ginger ale', 'bubbly'],
        ['soft drink', 'grapefruit soda', 'tangy', 'citrus'],

        // Tea
        ['tea', 'earl grey tea'],
        ['tea', 'green tea', 'jasmine'],
        ['tea', 'chamomile herbal tea'],
        ['tea', 'english breakfast tea'],
        ['tea', 'peppermint tea', 'refreshing'],
        ['tea', 'berry blend tea'],
        ['tea', 'rooibos tea', 'mellow'],
        ['tea', 'oolong tea', 'elegant', 'floral'],
        ['tea', 'matcha green tea', 'invigorating'],
        ['tea', 'lavender tea', 'relaxing', 'fragrant'],

        // Water
        ['water', 'spring water', 'purified'],
        ['water', 'mineral water', 'refreshing'],
        ['water', 'sparkling water'],
        ['water', 'coconut water', 'natural', 'tropical'],
        ['water', 'infused water', 'flavored'],
        ['water', 'sports water', 'electrolyte'],
        ['water', 'alkaline water', 'healthy'],
        ['water', 'vitamin water'],
        ['water', 'rose water', 'artisanal'],
        ['water', 'artesian water', 'premium'],

        // Milk and Others
        ['milk', 'whole milk', 'organic'],
        ['milk', 'almond milk', 'creamy'],
        ['milk', 'chocolate milk', 'rich'],
        ['milk', 'oat milk'],
        ['milk', 'soy milk', 'protein-packed'],
        ['milk', 'cashew milk'],
        ['milk', 'condensed milk', 'classic'],
        ['milk', 'coconut milk', 'delicious'],
        ['milk', 'peanut butter milkshake', 'creamy', 'indulgent'],
        ['milk', 'matcha latte', 'energizing', 'green']
    ];

    private array $drinksImages = [

    ];

    private array $households = [
        // Kitchen
        'Stainless Steel Cookware Set from KitchenEssentials',
        'Non-Stick Cookware Set from KitchenPro',
        'Copper Cookware Set from Chef\'s Choice',
        'Cast Iron Cookware Set from Chef\'s Choice',
        'Aluminum Cookware Set from ModernKitchen',
        'Titanium Cookware Set from KitchenPro',
        'Ceramic Cookware Set from KitchenPro',
        'Non-Stick Bakeware Collection from BakingMaster',
        'Versatile Blender from MixMaster',
        'Cutting-Edge Espresso Machine from CoffeeMasters',
        'Durable Food Storage Containers from FreshKeeper',
        'Multi-Function Air Fryer from CrispCrave',
        'Powerful Blender from SmoothieKing',
        'Convenient Rice Cooker from FluffyGrains',
        'Versatile Kitchen Scale from PrecisionMeasures',

        // Personal Care
        'Gentle Facial Cleanser from GlowGuru',
        'Moisturizing Body Lotion from SilkySmooth',
        'Anti-Aging Serum from EternalYouth',
        'Refreshing Shampoo and Conditioner Set from HairRevive',
        'Hydrating Face Mask from SpaLuxury',
        'Fragrance-Free Baby Wipes from TenderTouch',
        'Antiperspirant Deodorant from FreshEssence',
        'Whitening Toothpaste from Colgate',
        'Nourishing Hand Cream from SoftGlow',
        'Soothing Body Wash from ZenRelax',

        // Medicine
        'Pain Relief Cream from Medicare',
        'Children\'s Cold and Flu Syrup from Medicare',
        'Allergy Relief Tablets from Medicare',
        'Digestive Health Probiotics from Medicare',
        'Headache Relief Gel Caps from Medicare',
        'Sleep Aid Melatonin Tablets from Medicare',
        'Antacid Chewable Tablets from Medicare',
        'Multivitamin Gummies from Medicare',
        'Cough Suppressant Lozenges from Medicare',
        'First Aid Kit Essentials from Medicare',

        // miscellaneous
        'All-Purpose Cleaner Spray from SparkleShine',
        'Fresh Linen Scented Candle from CozyHome',
        'Handheld Vacuum Cleaner from QuickClean',
        'Pet Stain and Odor Remover from FurFree',
        'Stain-Resistant Carpet Cleaner from SpotlessFinish',
        'Laundry Detergent Pods from FreshBurst',
        'Natural Dish Soap from EcoClean',
        'Odor-Eliminating Air Freshener from FreshBreeze',
        'Lint Roller Set from FuzzFree',
        'Multipurpose Broom and Dustpan Set from SweepMaster'
    ];

    private array $householdCategories = [
        // Kitchen
        ['kitchen', 'cookware', 'stainless'],
        ['kitchen', 'cookware', 'non-stick'],
        ['kitchen', 'cookware', 'copper'],
        ['kitchen', 'cookware', 'cast iron'],
        ['kitchen', 'cookware', 'aluminum'],
        ['kitchen', 'cookware', 'titanium'],
        ['kitchen', 'cookware', 'ceramic'],
        ['kitchen', 'bakeware', 'non-stick'],
        ['kitchen', 'blender', 'versatile'],
        ['kitchen', 'espresso machine', 'cutting-edge'],
        ['kitchen', 'food storage containers', 'durable'],
        ['kitchen', 'air fryer', 'multi-function'],
        ['kitchen', 'blender', 'powerful'],
        ['kitchen', 'rice cooker', 'cookware'],
        ['kitchen', 'kitchen scale', 'versatile'],
    
        // Personal Care
        ['personal care', 'facial cleanser', 'gentle'],
        ['personal care', 'body lotion', 'moisturizing'],
        ['personal care', 'anti-aging serum', 'anti-aging'],
        ['personal care', 'shampoo', 'conditioner'],
        ['personal care', 'face mask', 'hydrating'],
        ['personal care', 'baby wipes', 'fragrance-free'],
        ['personal care', 'antiperspirant deodorant', 'fresh'],
        ['personal care', 'toothpaste', 'whitening'],
        ['personal care', 'hand cream', 'nourishing'],
        ['personal care', 'body wash', 'soothing'],
    
        // Medicine
        ['medicine', 'health', 'cream', 'soothing'],
        ['medicine', 'health', 'cold and flu ', 'syrup', 'children\'s'],
        ['medicine', 'health', 'allergy', 'tablets', 'relief'],
        ['medicine', 'health', 'probiotics', 'health'],
        ['medicine', 'health', 'headache relief gel caps', 'headache'],
        ['medicine', 'health', 'sleep aid tablets', 'sleep'],
        ['medicine', 'health', 'antacid chewable tablets', 'antacid'],
        ['medicine', 'health', 'multivitamin gummies', 'multivitamin'],
        ['medicine', 'health', 'cough suppressant lozenges', 'cough'],
        ['medicine', 'health', 'first aid kit essentials', 'first aid'],
    
        // Other
        ['miscellaneous', 'cleaner spray', 'all-purpose'],
        ['miscellaneous', 'scented candle', 'fresh linen'],
        ['miscellaneous', 'vacuum cleaner', 'handheld'],
        ['miscellaneous', 'stain and odor remover', 'pet'],
        ['miscellaneous', 'carpet cleaner', 'stain-resistant'],
        ['miscellaneous', 'laundry detergent pods', 'fresh'],
        ['miscellaneous', 'dish soap', 'natural'],
        ['miscellaneous', 'air freshener', 'odor-eliminating'],
        ['miscellaneous', 'lint roller set', 'lint'],
        ['miscellaneous', 'broom and dustpan set', 'multipurpose']
    ];

    private array $householdImages = [
        // kitchen
        'stainless_cookware_kitchenessentials.webp',
        'non_stick_cookware_kitchenpro.webp',
        'copper_cookware_cc.png',
        'cast_iron_cookware_cc.webp',
        'aluminum_cookware_mk.png',
        'titanium_cookware_kp.webp',
        'ceramic_cookware_kp.webp',
        'non_stick_bakeware_bm.webp',
        'blender_mixmaster.png',
        'espesso_machine_coffeemakers.png',
        'food_storage_container.png',
        'air_fryer_crispcrave.png',
        'blender_smoothking.png',
        'ricecooker_fluffygrains.webp',
        'kitchen_scale_rm.png',

        // personal care
        'facial_cleanser_gg.png',
        'body_lotion_silkysmooth.png',
        'serum_ey.webp',
        'shampoo_conditioner_hr.png',
        'hydrating_face_mask.webp',
        'baby_wipes_tendertouch.png',
        'deodorant_freshessence.webp',
        'tooth_paste.webp',
        'hand_cream_softglow.png',
        'body_wash_zenrelax.png',

        // medicine
        'pain_relief_cream.png',
        'cold_flu_syrup.webp',
        'allergy_relief_tablets.webp',
        'health_probiotics.webp',
        'headache_relief_gel_caps.webp',
        'sleep_aid_melatonin_tablets.webp',
        'antacide_chewable_tablets.webp',
        'Multivitamin_Gummies.webp',
        'Cough_Suppressant_Lozenges.png',
        'First_Aid_Kit_Essentials.png',

        // miscellaneous
        'cleaner_spray_sparkshine.webp',
        'linen_scented_candle_qucikclean.webp',
        'vcacuum_cleaner_quickclean.png',
        'stain_order_remover_ff.png',
        'stain_carpet_cleaner.png',
        'detergent_pods_fb.png',
        'dish_soap_ecoclean.png',
        'air_freshner_freshbreeze.webp',
        'lint_roller_fuzzfree.webp',
        'broom_dustpan_sweepmaster.png',
    ];

    private array $uniqueFoodCategories = [
        'fruits', 'tropical', 'citrus', 'dairy', 'milk', 'pantry',
        'bakery', 'bread', 'meat', 'chicken', 'beef',
        'seafood', 'fish', 'grains', 'rice', 'vegetables',
        'potatoes', 'tomatoes', 'lettuce', 'cucumbers', 'carrots',
        'cheese', 'butter', 'condiments', 'olive oil', 'pasta',
        'snacks', 'potato chips', 'trail mix', 'popcorn', 'granola bars',
        'pretzels', 'pickles', 'rice crackers', 'chocolate spread', 'honey',
        'mayonnaise', 'sriracha sauce', 'ketchup', 'barbecue sauce', 'taco seasoning',
        'asparagus', 'corn', 'green beans', 'bell peppers', 'spinach',
        'grape tomatoes', 'mushrooms', 'celery stalks', 'butternut squash'
    ];

    private array $uniqueDrinksCategories = [
        'alcohol', 'whiskey', 'beer', 'refreshing', 'craft',
        'vodka', 'rum', 'aged', 'spice',
        'white wine', 'gin', 'tequila', 'agave', 'rich',
        'craft beer', 'flavorful', 'sake', 'soothing', 'traditional',
        'soft drink', 'cola', 'sparkling', 'lemon-lime soda',
        'orange fizz', 'pineapple punch', 'root beer',
        'strawberry soda', 'mango fizz', 'exotic', 'apple cider',
        'ginger ale', 'grapefruit soda', 'tangy',
        'tea', 'earl grey tea', 'green tea', 'jasmine',
        'chamomile herbal tea', 'english breakfast tea',
        'peppermint tea', 'berry blend tea', 'rooibos tea', 'mellow',
        'oolong tea', 'elegant', 'floral', 'matcha green tea', 'invigorating',
        'lavender tea', 'relaxing', 'fragrant',
        'water', 'spring water', 'purified', 'mineral water',
        'coconut water', 'infused water', 'sparkling water',
        'sports water', 'alkaline water', 'vitamin water',
        'rose water', 'artisanal', 'artesian water', 'premium',
        'milk', 'whole milk', 'almond milk', 'chocolate milk',
        'oat milk', 'soy milk', 'cashew milk', 'condensed milk',
        'coconut milk', 'peanut butter milkshake', 'matcha latte', 'energizing', 'green',
    ];

    private array $uniqueHouseholdCategories = [
        'kitchen', 'cookware', 'stainless', 'bakeware', 'non-stick',
        'blender', 'versatile', 'espresso machine', 'cutting-edge',
        'food storage containers', 'durable', 'slow cooker', 'efficient',
        'air fryer', 'multi-function', 'rice cooker', 'convenient',
        'kitchen scale', 'personal care', 'facial cleanser', 'gentle',
        'body lotion', 'moisturizing', 'anti-aging serum', 'shampoo and conditioner set',
        'refresher', 'face mask', 'hydrating', 'baby wipes', 'fragrance-free',
        'antiperspirant deodorant', 'fresh', 'toothpaste', 'whitening',
        'hand cream', 'nourishing', 'body wash', 'soothing', 'medicine',
        'pain relief cream', 'cold and flu syrup', 'children\'s',
        'allergy relief tablets', 'relief', 'digestive health probiotics', 'health',
        'headache relief gel caps', 'sleep aid tablets', 'sleep',
        'antacid chewable tablets', 'multivitamin gummies', 'cough suppressant lozenges',
        'first aid kit essentials', 'Miscellaneous', 'cleaner spray', 'all-purpose',
        'scented candle', 'fresh linen', 'vacuum cleaner', 'handheld',
        'stain and odor remover', 'pet', 'carpet cleaner', 'stain-resistant',
        'laundry detergent pods', 'dish soap', 'natural',
        'air freshener', 'odor-eliminating', 'lint roller set', 'lint',
        'broom and dustpan set', 'multipurpose',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** seeding categories */
        foreach(array_unique($this->uniqueFoodCategories) as $foodCategory)
        {
            Category::factory()->create([
                'type' => 'Food',
                'sub_type' => ucwords($foodCategory),
            ]);
        }
        foreach(array_unique($this->uniqueDrinksCategories) as $drinkCategory)
        {
            Category::factory()->create([
                'type' => 'Drinks',
                'sub_type' => ucwords($drinkCategory),
            ]);
        }
        foreach(array_unique($this->uniqueHouseholdCategories) as $householdCategory)
        {
            Category::factory()->create([
                'type' => 'Households',
                'sub_type' => ucwords($householdCategory),
            ]);
        }

        /** seeding products */
        foreach($this->foods as $index => $food)
        {
            $in_stock = rand(785, 2421);
            $minimum_stock = 250;
            $available_stock = $in_stock - $minimum_stock;

            $inventory = Inventory::create([
                'sku' => 'YM-' . strtoupper(uniqid()),
                'vendor_id' => 1,
                'in_stock_quantity' => $in_stock,
                'minimum_quantity' => $minimum_stock,
                'available_quantity' => $available_stock,
                'is_in_stock' => $available_stock > 0,
                'status' => ($available_stock >= 50) ? 'sell' : 'close',
            ]);

            $product = Product::factory()->create([
                'inventory_id' => $inventory->id,
                'name' => ucwords($food),
                'slug' => strtolower(str_replace(' ', '-', $food)),
                'meta_type' => strtolower(explode(' ', $food)[0]),
                // 'image' => $this->foodImages[$index],
            ]);

            $categoryIds = [];
            $categoryIds = Category::whereIn('sub_type', $this->foodCategories[$index])->pluck('id')->toArray();
            $product->categories()->sync($categoryIds);
        }

        foreach($this->drinks as $index => $drink)
        {
            $in_stock = rand(150, 542);
            $minimum_stock = 150;
            $available_stock = $in_stock - $minimum_stock;

            $inventory = Inventory::create([
                'sku' => 'YM-' . strtoupper(uniqid()),
                'vendor_id' => 1,
                'in_stock_quantity' => $in_stock,
                'minimum_quantity' => $minimum_stock,
                'available_quantity' => $available_stock,
                'is_in_stock' => $available_stock > 0,
                'status' => ($available_stock >= 50) ? 'sell' : 'close',
            ]);

            $product = Product::factory()->create([
                'inventory_id' => $inventory->id,
                'name' => ucwords($drink),
                'slug' => strtolower(str_replace(' ', '-', $drink)),
                'meta_type' => strtolower(explode(' ', $drink)[0]),
                // 'image' => $this->drinksImages[$index],
            ]);

            $categoryIds = [];
            $categoryIds = Category::whereIn('sub_type', $this->drinksCategories[$index])->pluck('id')->toArray();
            $product->categories()->sync($categoryIds);
        }

        foreach($this->households as $index => $household)
        {
            $in_stock = rand(250, 2421);
            $minimum_stock = 250;
            $available_stock = $in_stock - $minimum_stock;

            $inventory = Inventory::create([
                'sku' => 'YM-' . strtoupper(uniqid()),
                'vendor_id' => 1,
                'in_stock_quantity' => $in_stock,
                'minimum_quantity' => $minimum_stock,
                'available_quantity' => $available_stock,
                'is_in_stock' => $available_stock > 0,
                'status' => ($available_stock >= 50) ? 'sell' : 'close',
            ]);

            $product = Product::factory()->create([
                'inventory_id' => $inventory->id,
                'name' => ucwords($household),
                'slug' => strtolower(str_replace(' ', '-', $household)),
                'meta_type' => strtolower(explode(' ', $household)[0]),
                'image' => $this->householdImages[$index],
            ]);

            $categoryIds = [];
            $categoryIds = Category::whereIn('sub_type', $this->householdCategories[$index])->pluck('id')->toArray();
            $product->categories()->sync($categoryIds);
        }
    }
}
