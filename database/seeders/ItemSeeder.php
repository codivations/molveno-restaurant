<?php

namespace Database\Seeders;

use App\Enums\MenuService;
use App\Models\Item;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drinkService = Menu::factory()->create([
            "service" => MenuService::DRINKS,
        ]);
        $breakfastService = Menu::factory()->create([
            "service" => MenuService::BREAKFAST,
        ]);
        $lunchService = Menu::factory()->create([
            "service" => MenuService::LUNCH,
        ]);
        $dinnerService = Menu::factory()->create([
            "service" => MenuService::DINNER,
        ]);
        $snackService = Menu::factory()->create([
            "service" => MenuService::SNACKS,
        ]);

        $drinkItems = [
            "Coffee",
            "Cappuccino",
            "Espresso",
            "Caffè Ristretto",
            "Beer",
            "Bud Light",
            "Budweiser",
            "Miller Lite",
            "Milk Shake",
            "Tea",
            "Sweet Tea",
            "Coffee",
            "Hot Tea",
            "Champagne",
            "Wine",
            "Lemonade",
            "Coca-Cola",
            "Diet Coke",
            "Sprite",
            "Orange Juice",
            "Iced Coffee",
        ];

        $breakfastItems = [
            "American Pancakes",
            "Cheese Omelette",
            "Potato Fritters",
            "Breakfast Hash",
            "Chocolate-orange French Toast",
            "Calico Pepper Frittata",
            "Frittata Florentine",
            "Tiramisu Crepes",
            "Arugula & Mushroom Breakfast Pizza",
            "Shakshuka",
            "Pane Burro e Marmellata",
            "Cornetto",
            "Fette Biscottate",
            "Biscotti",
            "Saccottino",
            "Cannoli",
            "Maritozzi",
            "Cantucci",
            "Ciambella",
            "Zeppole",
        ];

        $lunchItems = [
            "Potato Crumb Pie",
            "Pasta alla Crudaiola",
            "Grilled Calamari",
            "Tuna Carpaccio",
            "Eggplant and Mozzarella Salad with Rosemary Bruschetta",
            "Red Onion and Olive Focaccia",
            "Grilled Chicken with Salmoriglio",
            "Celery, Kohlrabi and Radish Salad with Basil Cream",
            "Insalata di Mare",
            "Chickpea, Baccalà and Lemon Salad",
            "Tagliata Salad with Warm Garlic and Anchovy Dressing",
            "Tomato and Baked Ricotta Pasta Freddo",
            "Porcini and Taleggio Fried Sandwiches",
            "Muffaletta",
            "Gnudi",
            "Polpette and Provolone Cantina Rolls",
            "Sarde e Beccafico",
            "Prawn and White Bean Salad with Tomato Dressing",
            "Provolone Piccante Arancini with Thyme and Garlic Aioli",
            "Sopressa, Coppa, Provolone and Peperonata on Olive Bread",
        ];

        $dinnerItems = [
            "Pasta alla Crudaiola",
            "Pasta Puttanesca",
            "Cacio e Pepe",
            "Beef Ragu",
            "Chicken Piccata",
            "Skillet Eggplant Parm",
            "White Pizza",
            "Ricotta Gnudi",
            "Burrata Salad",
            "Carbonara Pizza",
            "Chicken Parmesan",
            "Osso Buco",
            "Chicken Marsala",
            "Spaghetti Carbonara",
            "Caprese Chicken Saltimbocca",
            "Cavatelli",
            "Frittata",
            "Skillet Chicken Cacciatore",
            "Pasta Alla Gricia",
            "Chicken Saltimbocca",
        ];

        $snackItems = [
            "Shrimp Stuffed Avocado",
            "Savory Crescents",
            "Grilled Zucchini Roll-Ups",
            "Cheesy Zucchini Bites",
            "Roman Pinsa Pizza",
            "Olive Salad",
            "Suppli Al Telefono",
            "Bruschetta",
            "Cantuccini",
            "Taralli",
            "Gelato",
            "Panzerotti",
            "Arancini",
            "Tramezzino",
            "Panino Imbottito",
            "Polpettine",
            "Crostini",
            "Antipasto Platter",
            "Grissini",
            "Focaccia",
            "Parmesan Arancini Balls",
        ];

        $this->createItems($drinkItems, $drinkService->id, 150, 350);
        $this->createItems($breakfastItems, $breakfastService->id, 250, 700);
        $this->createItems($lunchItems, $lunchService->id, 300, 1000);
        $this->createItems($dinnerItems, $dinnerService->id, 500, 3000);
        $this->createItems($snackItems, $snackService->id, 250, 700);
    }

    private function createItems(
        array $itemList,
        int $serviceId,
        int $minPrice,
        int $maxPrice
    ): void {
        foreach ($itemList as $item) {
            $currentItem = Item::factory()->create([
                "name" => $item,
                "price" => fake()->numberBetween($minPrice, $maxPrice),
            ]);
            $currentItem->menus()->attach($serviceId);
        }
    }
}
