// Migration for rodovias
public function up()
{
    Schema::create('rodovias', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->timestamps();
    });
}