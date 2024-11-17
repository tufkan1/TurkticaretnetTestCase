## Turkticaret.net Test Case

Bu dökümantasyon, turkticaret.net test case için hazırlanmıştır.

## Gereksinimler
Aşağıdaki araçların sisteminizde kurulu olduğundan emin olun:

- PHP (>= 8.1) 
- Composer
- Git
- Node.js (>= 16.x) ve npm/yarn
- Laravel Artisan CLI


## Kurulum Adımları
1. **Projeyi Klonlayın**  
Proje deposunu bilgisayarınıza klonlayın:
```bash
git clone https://github.com/tufkan1/TurkticaretnetTestCase.git
```

Proje klasörüne girin:
```bash
cd TurkticaretnetTestCase
```


2. **Ortam Dosyasını Ayarlama**
<p>.env dosyasını oluşturun:</p>

```bash
cp .env.example .env
```

Ortam dosyasını ayarlarında bulunan veritabanı bilgilerinizi güncelleyin

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

3. **Gerekli Paketleri Kurun**

```bash
composer install
```


4. **Uygulamayı Kurun**

Benzersiz Key Olusturun
```bash
php artisan key:generate
```
JWT Secret Oluşturma
```bash
php artisan jwt:secret
```
Veritabanı Migrasyon ve Seed İşlemleri
```bash
php artisan migrate:fresh --seed
```

5. **Uygulamayı Çalıştırın**

```bash
php artisan serve
```
