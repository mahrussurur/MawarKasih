
<?php

use App\Models\ProfilDonatur;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;


// Menguji method user() pada model ProfilDonatur
test('method user memiliki relasi belongsTo dengan model User', function () {
    $profilDonatur = new ProfilDonatur();

    $relasi = $profilDonatur->user();

    expect($relasi)->toBeInstanceOf(BelongsTo::class)
        ->and($relasi->getRelated())->toBeInstanceOf(User::class)
        ->and($relasi->getForeignKeyName())->toBe('user_id')
        ->and($relasi->getOwnerKeyName())->toBe('id');
});
