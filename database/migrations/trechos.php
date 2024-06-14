public function up()
{
    Schema::create('trechos', function (Blueprint $table) {
        $table->id();
        $table->date('data_referencia');
        $table->foreignId('uf_id')->constrained('ufs');
        $table->foreignId('rodovia_id')->constrained('rodovias');
        $table->float('quilometragem_inicial');
        $table->float('quilometragem_final');
        $table->json('geo')->nullable();
        $table->timestamps();
    });
}