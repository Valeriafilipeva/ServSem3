<?php

namespace Database\Factories;
// Фабрика данных (фабрика данных) в Laravel 
// — это класс, который определяет, как создаются экземпляры моделей
// Экземпляр модели - это конкретный объект класса модели,
//  который содержит одну запись данных из таблицы базы данных


use Illuminate\Database\Eloquent\Factories\Factory;
// Используется класс Factory из пакета Laravel для создания фабрики данных.

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 * 
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'shortDesc' => $this->faker->paragraph,
            'desc' => $this->faker->paragraph,
            'preview_image' => $this->faker->paragraph,
        ];
    }
}
