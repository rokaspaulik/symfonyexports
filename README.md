# symfonyexports
Simple Symfony3 exports example with basic table
## used libs
[phpoffice/phpspreadsheet](https://github.com/PHPOffice/PhpSpreadsheet) and
[tecnickcom/TCPDF](https://github.com/tecnickcom/TCPDF) along with
[whiteoctober/WhiteOctoberTCPDFBundle](https://github.com/whiteoctober/WhiteOctoberTCPDFBundle) (TCPDF Bundle for Symfony applications)
## routes
> Table view
* /
> Exports to Excel
* /excel
> Exports to PDF
* /pdf
> Adds new table entry
* /add
## database
Open console and run `php bin/console doctrine:database:create` to create new database
for this project. Before running the command you may want to edit database config file which is
located at `app/config/parameters.yml`
## usage
Just run `php bin/console server:start` to start VM, then access routes in URL as `http://localhost:8000/{route}`