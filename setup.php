<?php
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

require 'src/bootstrap.php';

if ($argc <= 1 or !in_array($argv[1], ['create', 'drop'])) {
    echo "Usage:\nphp {$argv[0]} create\nphp {$argv[0]} drop\n";
    return;
}
$action = $argv[1];

$schema = Manager::schema();

if ($action == 'create') {
    $schema->create('images', function (Blueprint $table) {
        $table->increments('id');
        $table->string('category', 128)->default('default')->index();
        $table->text('origin_url')->nullable();
        $table->string('local_path', 256)->nullable();
        $table->string('comment', 256)->nullable();
        $table->boolean('downloaded')->default(false)->index();
        $table->text('extra')->nullable();
        $table->timestamps();
    });
    
    $schema->create('state', function (Blueprint $table) {
        $table->increments('id');
        $table->string('sender', 32);
        $table->string('state', 256)->nullable();
        $table->timestamps();
    });
} else if ($action == 'drop') {
    $schema->dropAllTables();
}

