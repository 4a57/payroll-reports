# Payroll Reports

## Wstęp
Na wstępie zaznaczę, że w projekcie jest sporo overengineeringu, ale chyba o to chodzi w takich zadaniach :) Podejście, którego użyłem nie jest najlepsze dla większości sytuacji (cała logika, filtrowanie i sortowanie w pamięci PHP), ale dzięki temu mogłem pokazać trochę więcej kodu. W normalnej sytuacji dla takiego przykładu zrobiłbym pewnie jedno query i wrzucił to wszystko w ładne zapytanie do bazy.

## Obsługa
Projekt jest postawiony na dockerze i można go odpalić jedną komendą.
Żeby uruchomić cały pipeline od buildu przez zasilenie przykładowymi danymi po start kontenera z CLI wystarczy wpisać w terminalu
```shell
make run-from-scratch
```
Następnie można odpalać właściwą komendę. Oto kilka przykładów:
```shell
php bin/console app:generate-payroll-report
php bin/console app:generate-payroll-report -s baseSalary
php bin/console app:generate-payroll-report -s baseSalary -d desc
php bin/console app:generate-payroll-report -f HR
php bin/console app:generate-payroll-report -f Engineering Zofia
php bin/console app:generate-payroll-report -f Nowak
php bin/console app:generate-payroll-report -f Eng -s totalSalary -d desc
```
Uruchomienie samych testów:
```shell
make run-tests
```
