<?hh // strict

namespace Hack\UserDocumentation\AsyncOps\Guidelines\Examples\Lambdas;
use namespace HH\Lib\Vec;

// For asio-utilities that we installed via composer
require __DIR__ . "/../../../../vendor/hh_autoload.php";

async function fourth_root(num $n): Awaitable<float> {
  return \sqrt(\sqrt($n));
}

async function normal_call(): Awaitable<vec<float>> {
  $nums = vec[64, 81];
  return await Vec\map_async(
    $nums,
    fun('\Hack\UserDocumentation\AsyncOps\Guidelines\Examples\Lambdas\fourth_root')
  );
}

async function closure_call(): Awaitable<vec<float>> {
  $nums = vec[64, 81];
  $froots = async function(num $n): Awaitable<float> {
    return \sqrt(\sqrt($n));
  };
  return await Vec\map_async($nums, $froots);
}

async function lambda_call(): Awaitable<vec<float>> {
  $nums = vec[64, 81];
  return await Vec\map_async($nums, async $num ==> \sqrt(\sqrt($num)));
}

async function use_lambdas(): Awaitable<void> {
  $nc = await normal_call();
  $cc = await closure_call();
  $lc = await lambda_call();
  \var_dump($nc);
  \var_dump($cc);
  \var_dump($lc);
}

<<__Entrypoint>>
function main(): void {
  \HH\Asio\join(use_lambdas());
}

