# JQuery ve PHP ile sitenize giren misafirin konum bilgilerini alma & görüntüleme

Sitenize erişim sağlayan kullanıcıları listelemek için kullanıcının iki şartı sağlaması gerekmektedir.

* Geolocation Desteği
* Kullanıcının Konum Bilgilerine Erişim İzni

## Nasıl Yapılır?

Sitenizin index sayfasında `window.addEventListener("load", function(){})` tetikleyici fonksiyonunuzu barındırmanız gerekir. Sayfa yüklendiği gibi 
```
if (navigator.geolocation)
{
navigator.geolocation.getCurrentPosition(showPosition,showError);
}
```
komutuyla, Navigator'ün .gelocation özelliği var mı yok mu onu kontrol etmeniz gerekir.
Eğer varsa mevcut konumunu almak için yukarıdaki kodu inceleyebilirsiniz. `( Konum Bilgilerini göndereceği Fonksiyon, Hata Yakalayacağı Fonksiyon )`


```
  function showPosition(position) {
          $.post(
            "konumbilgileri.php",
            {
              enlem: position.coords.latitude,
              boylam: position.coords.longitude,
            },
            function (data, status) {}
          );
        }
```

Kullanıcının enlem ve boylam bilgilerine ulaşıldığında, bu bilgileri `konumbilgileri.php` sayfasına **POST** yöntemiyle atabilirsiniz.

`konumbilgileri.php` sayfanıza gelen enlem, boylam bilgilerini veritabanına yazdırıp, saklayabilirsiniz.
Hangi linkten geldiğini öğrenmek için de `$link = $_SERVER['HTTP_REFERER'];`  kullanabilirsiniz.

Daha sonra ise [Marker Clustering](https://developers.google.com/maps/documentation/javascript/marker-clustering) ile harita üzerinde işaretleyebilirsiniz.



![site](https://user-images.githubusercontent.com/44155358/137292499-b807360e-1918-4dad-85b8-93b27100d2ad.png)
