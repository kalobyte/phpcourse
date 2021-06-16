<?php
require "./vendor/autoload.php";

use App\QueryBuilder;

$mysql = [
    "host" => "localhost",
    "username" => "immersion",
    "password" => "immersion",
    "database" => "immersion"];

$query = new QueryBuilder($mysql);

$users = $query->select("users");

echo "### dumper ### <br><br>";
dump($users);
echo "<br><br>";


echo "### faker ### <br><br>";
$faker = Faker\Factory::create();

for ($i=0; $i<10; $i++ )
{
    echo $i. " - ". $faker->name() . " - " . $faker->email() . "<br>";
}
echo "<br><br>";


echo "### qr code ### <br><br>";

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

$data = "BEGIN:VCARD
VERSION:3.0
N:Nachname;Vorname
FN:Vorname Nachname
ORG:Unternehmensname
ADR;WORK:;;Straße Hausnummer;Ort;;Postleitzahl
TEL;WORK;VOICE:+49 7531 12345
TEL;TYPE=CELL:+49 178 12345678
TEL;WORK;FAX:+49 7531 123456
URL:http://www.website.com/
EMAIL;INTERNET:email.address@website.com
END:VCARD";

$renderer = new ImageRenderer(
    new RendererStyle(400),
    new ImagickImageBackEnd()
);
$writer = new Writer($renderer);
$writer->writeFile($data, 'qrcode.png');

echo "<img src='qrcode.png'>";