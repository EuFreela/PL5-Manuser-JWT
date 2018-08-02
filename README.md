# PL5-Manuser-JWT
#### Packager Manager User com JWT

<p>Packagers são interessantes para otimização de trabalho com programação. Eventos que são comuns a cada projeto poderão ser reaproveitados. Para evitar programar sempre a mesma rotina, os packagers ajudam a acelerar esse processo mantendo você ocupado com o que é realmente necessário. Em resumo, trata-se de otimização das rotinas.</p>
<p>Este packager tem o objetivo de otimizar o roteamento, controllers e middleware para credenciamento utilizando RestFull com JWT.</p>
<br>
<a href="https://packagist.org/packages/lameck/manuser">Assinatura: Packagerlist</a>

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
<br>
<p>Pare o servidor, se estiver rodando e limpe o cache. Após, reinicie:<br>
<b>php artisan cache:clear;php artisan serve</b></p><br>
Se não fizer isso é possivel que a mensagem de erro seja: <b>"Acesso negado"</b>

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

<b>php artisan db:seed</b><br>
<b>php artisan jwt:secret</b>

Utilize o postman para testar a api.<br>
<p>POST</p>
<blockquote>localhost:8000/manuser/authenticate?email=jerry@gmail.com&password=secret</blockquote>
<br>
<img src="https://s18.postimg.cc/nhr3b26gp/Captura_de_tela_de_2018-03-25_20-56-48.png" width="900" height="500"

<br>
<p>GET</p>
<blockquote>localhost:8000/manuser/users?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvbWFudXNlclwvYXV0aGVudGljYXRlIiwiaWF0IjoxNTIyMDIwNTc5LCJleHAiOjE1MjIwMjQxNzksIm5iZiI6MTUyMjAyMDU3OSwianRpIjoidzA0YnRpejU3Q1NZRjRuZyIsInN1YiI6MSwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.xMWZb27t-VgyE5BbR0N5l1Iyf4Y4n5QBF-IuBA_CJgQ</blockquote>
<br>
<img src="https://s18.postimg.cc/6v9j1l0jt/Captura_de_tela_de_2018-03-25_21-03-13.png" width="900" height="500"
<BR>


<HR>
<p>Em resumo, o packager trata-se de uma automação de uso com API RestFull utilizando JWT - não utilizamos mais o token nativo VerifyCsrfToken - principalmente para cross-site-script, em seu lugar estamos usando JWT. Para utilizarmo-lo, faz-se necessário a configuração manual - comum para quem já é veterano com o framework laravel.</p>
<p>Estarei disponibilizando mais detalhes na <a href="https://github.com/EuFreela/PL5-Manuser-JWT/wiki">wiki</a></p>


<hr>

### Detalhe
<p>O numero de requisições por default esta 1,1 (1 requisição por minuto - throttle:1,1). Para auterar este valor, basta acessar as dependencias vendor/lameck/manuser/route.php. O primeiro valor é o numero de requisiçes e o segundo é o tempo decorrido até a próxima requisição.</p>
<blockquote><pre>
Route::group(['prefix' => 'manuser'], function()
{
    Route::post('authenticate', '\Lameck\Manuser\ManuserController@authenticate');
    Route::middleware('jwt.auth','throttle:1,1')->get('users','\Lameck\Manuser\ManuserController@users');
});
</pre><blockquote>






