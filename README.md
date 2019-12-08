# Instrukcja Konfiguracji i Użytkowania Skryptu „Media Access Token&quot;

# Struktura

Pliki skryptu są rozmieszczone w trzech folderach.

## Folder src

W tym folderze znajdują się źródła mechanizmu tokenowego/wzorcowego. O ile nie jest to koniecznie, tych plików nie należy edytować.

## Folder pliki

W tym folderze znajdują się wszystkie plik multimedialne, do których wyświetlania zostanie wykorzystany skrypt.

## Folder custom

W tym folderze znajdują się pliki konfiguracyjne oraz wyglądowe.

# Konfiguracja

Przed wgraniem plików na serwer należy otworzyć plik **config.php** z folderu **custom.**

W pliku tym znajduje się seria zmiennych , które określają wyświetlane teksty oraz klucz dostępu.

## Klucz dostępu

Określony w zmiennej $klucz jest hasłem, który pozwala na zdalne zapisanie wzorca. Może się składać z takiej samej kombinacji znaków, jak wzorzec.

## Teksty

Poniższe teksty wyświetlane są w poszczególnych miejscach na stronie.

$nazwaWydarzenia – Tytuł udostępnianego wydarzenia.

$tekstWStopce - Treść stopki, widocznej w dolnej części strony.

$polecenieLogowania – Tekst widoczny nad polem do wpisania tokenu.

$przyciskLogowania – Tekst widoczny na przycisku logowania

$przyciskLogowaniaWeryfikacja - Tekst widoczny na przycisku logowania podczas weryfikacji tokenu.

$przyciskLogowaniaZlyToken - Tekst informujący o podaniu złego tokenu.

$przyciskLogowaniaOk - Tekst informujący o pozytywnej weryfikacji tokenu.

$przyciskLogowaniaBrakPliku - Tekst informujący o braku pliku, mimo podania tokenu zgodnego ze wzorcem.

$przyciskPobierz – Tekst widoczny na przycisku pobrania materiału.

$zlyToken  - Komunikat błędu po podaniu tokenu niezgodnego ze wzorcem.

$brakPliku = Komunikat błędu po podaniu tokenu zgodnego ze wzorcem, ale niepasującego do żadnego z plików.

$tytulBledu = Tytuł komunikatu z błędem.

$polecenieBledu = Polecenie po komunikacie z błędem.

## Styl

Do ogólnego stylu stron wykorzystano pakiet Bootstrap (Dokumentacja dostępna pod adresem: [https://getbootstrap.com/](https://getbootstrap.com/))

Do nadpisania i modyfikowania istniejących styli należy wykorzystać plik **mojstyl.css** z folderu **custom**.

## Wzorzec

Wzorzec wykorzystywany przez skrypt musi mieć przynajmniej 4 znaki i może się składać wyłącznie z liter, pisanych dużą literą: **L,C,S.** Litery te oznaczają, odpowiednio: L -litera , C – cyfra oraz S – symbol.

Pod **L** iterami mogą znajdować się wszystkie litery alfabetu z pominięciem liter ze znakami diakrytycznymi (tj. ą, ę , ć itp.). Wielkość litery ma znaczenie! Token **ABC1** jest różny od **AbC1**.

Pod **C** yframi mogą znajdować się wszystkie cyfry arabskie.

Pod **S** ymbolem może znajdować się jeden z poniższych znaków:

\_ **$ - + = ! @**

Wzorzec zapisany jest w pliku **p**** attern **w folderze** custom**.

## Zdalne zapisywanie wzorca

Skrypt umożliwia zapisanie nowego wzorca poprzez wywołanie/otwarcie właściwego adresu URL.

Do adresu galerii (strony logowania) należy dopisać ?nw=NOWYWZORZEC&amp;k=KLUCZ, gdzie NOWYWZORZECZ będzie nowym wzorcem, a KLUCZ będzie kluczem ustawionym w pliku **config.php** , np.: http://www.mojastrona.pl/galeria123?nw=LLCCCSSSLC&amp;k=12345.

## Zdalna weryfikacja tokenu

Jest możliwe zweryfikowanie zgodności tokenu ze wzorcem oraz potwierdzenia istnienia właściwego pliku odwołując się do adresu z końcówką ?vt=TOKEN, gdzie TOKEN to sprawdzany token, np.:

http://www.mojastrona.pl/galeria123?vt=A1daS$\_324.

# Strona Logowania

Domyślną stroną, widoczną w przypadku braku podania tokenu, lub jego błędu, jest strona logowania. W widocznym polu należy wpisać odpowiedni token, aby uzyskać dostęp do pliku.

# Wyświetlanie Pliku

Dostęp do pliku jest możliwy na dwa sposoby – wykorzystując stronę logowania wpisując właściwy token lub za pomocą bezpośredniego odnośnika z końcowką ?t=TOKEN, gdzie TOKEN to podany token zdjęcia, np.: http://www.mojastrona.pl/galeria123?t=A1daS$\_324.

Na stronie pliku dostępny jest przycisk umożliwiający pobranie pliku. Odtwarzacz multimedialny obsługuje wszystkie popularne formaty obrazu i wideo, jednak dla zapewnienia najszerszej kompatybilności zaleca się wykorzystywanie formatu **mp4** do plików wideo **oraz bmp,jpg,png i gif** do plików zdjęć.

# Wgrywanie skryptu na serwer

W katalogu, do którego prowadzi adres internetowy, należy wrzucić w całości folder **custom** , **src** oraz pliki **index.php** i, **co najważniejsze** , plik . **htaccess** – Uniemożliwi to użytkownikowi przeglądanie zawartości folderu **pliki**. Jeśli na serwerze, w docelowym folderze istnieje już plik **.htaccess** , należy do niego wpisać treść pliku z paczki.
