<?php

// Migration for ufs
public function up()
{
    Schema::create('ufs', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->timestamps();
    });
}

