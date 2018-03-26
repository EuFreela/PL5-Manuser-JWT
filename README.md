# PL5-Manuser-JWT
#### Packager Manager User com JWT

<p>Packager so interessantes para otimização de trabalho com programação. Eventos que são comuns a cada projeto poderão ser aproveitados. Para evitar programar sempre a mesma rotina, os packager ajudam a acelerar esse processo mantendo você ocupado com o que é necessário. Em resumo, trata-se de otimização das rotinas.</p>
<p>Este packager tem o objetivo de otimizar o roteamento, controllers e middleware para credenciamento utilizando RestFull.</p>

<hr>

#### INSTALAÇÃO

<o>
  <li>1. <b>composer require lameck/manuser</b></li>
  <li>2. <b>php artisan vendor:publish --provider="Lameck\Manuser\ManuserServiceProvider"</b></li>
</o>

<hr>

##### PROVIDER: app/config/app.php
<blockquote><pre>
...
  Lameck\Manuser\ManuserServiceProvider::class,
	Tymon\JWTAuth\Providers\LaravelServiceProvider::class
</pre></blockquote>

<hr>

##### ALIAS: app/config/app.php
<blockquote><pre>
  'JWTAuth'   => Tymon\JWTAuthFacades\JWTAuth::class,
	'JWTFactory' => Tymon\JWTAuthFacades\JWTFactory::class
</pre></blockquote>
  
 <hr>
 
#### KERNEL: app/http/kernel.php
Comente a linha:<br>
<blockquote><b>//\App\Http\Middleware\VerifyCsrfToken::class,</b><br></blockquote>
Adicione em routemiddlware:<br>
<blockquote>
        <b>'jwt.auth' => Tymon\JWTAuth\MiddlewareGetUserFromToken::class,</b><br>
        <b>'jwt.refresh' => TymonJWTAuth\MiddlewareRefreshToken::class</b>
</blockquote>

Comente:<br>
<blockquote><b>//'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,</b><br></blockquote>
Adicione:<br>
<blockquote><b>'throttle' => \Lameck\Manuser\ThrottleRequestsMiddleware::class,</b></blockquote>

<hr>

#### MODEL USER

Adicione em na classe:<br>
<blockquote><pre>
<b>use Tymon\JWTAuth\Contracts\JWTSubject;</b>
<b>public function getJWTCustomClaims(): array {
        return [];
    }</b>
<b>public function getJWTIdentifier(){
        return $this->getKey();
    }
</b>
</pre></blockquote>

<hr>


### EXEMPLO
Crie um banco de dados e carregue um seeder:<br>
<b>php artisan migrate</b><br>
<b>php artisan make:seeder UsersTableSeeder</b><br>
<blockquote><pre>
DB::table('users')->delete();
  $users = array(
          ['name' => 'Jerry Cantrell', 'email' => 'jerry@gmail.com', 'password' => Hash::make('secret')],
          ['name' => 'Ozzy Osbuorne', 'email' => 'ozzy@me.io', 'password' => Hash::make('secret')],
          ['name' => 'Leney Stanley', 'email' => 'leney@me.io', 'password' => Hash::make('secret')],
          ['name' => 'Kurtney Love', 'email' => 'kurtney@me.io', 'password' => Hash::make('secret')],
  );
  DB::table('users')->insert($users);
</pre></blockquote>

<b>php artisan db:seed</b>

Utilize o postman para testar a api.<br>
<p>POST</p>
<blockquote>localhost:8000/manuser/authenticate?email=jerry@gmail.com&password=secret</blockquote>
<br>
<img src="https://s18.postimg.org/nhr3b26gp/Captura_de_tela_de_2018-03-25_20-56-48.png" width="300" height="300"










