<?php


use Filament\Facades\Filament;
use App\Filament\Resources\ProductResource;
use App\Filament\Resources\CategoryResource;

Filament::serving(function () {
    Filament::registerResources([
        ProductResource::class,
        CategoryResource::class,
    ]);
});
