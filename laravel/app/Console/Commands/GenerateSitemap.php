<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera el archivo sitemap.xml';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Crea el sitemap
        $sitemap = Sitemap::create();

        // Añade las rutas principales del sitio
        $sitemap->add(Url::create('/')
            ->setPriority(1.0)
            ->setChangeFrequency('daily'));

        $sitemap->add(Url::create('/about')
            ->setPriority(0.8)
            ->setChangeFrequency('weekly'));

        // Aquí puedes añadir dinámicamente URLs desde tu base de datos
        $products = \App\Models\Product::all(); // Ejemplo con productos
        foreach ($products as $product) {
            $sitemap->add(Url::create("/product/{$product->slug}")
                ->setPriority(0.9)
                ->setChangeFrequency('weekly'));
        }

        // Guarda el archivo sitemap.xml en la carpeta public
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('¡Sitemap generado exitosamente!');

        return Command::SUCCESS;
    }
}
