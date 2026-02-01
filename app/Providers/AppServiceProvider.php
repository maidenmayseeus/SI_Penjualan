<?php

namespace App\Providers;

use Spatie\Health\Health;
use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseTableSizeCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    app(Health::class)->checks([
      OptimizedAppCheck::new(),
      DebugModeCheck::new(),
      EnvironmentCheck::new(),
      CacheCheck::new(),
      UsedDiskSpaceCheck::new(),
      DatabaseTableSizeCheck::new()
        ->table('produks', 1000),
    ]);
  }
}
