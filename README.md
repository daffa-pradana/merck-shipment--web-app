# M - Shipment Report ( Web app )

Web based shipment report for Merck Indonesia especially import and export division.<br>This Web Application used for managing, documenting, and reporting export - import<br>activity to keep each of those activity in track.

##### Disclaimer

This web app project is made by an intern at Merck Indonesia which initiated and<br>supervised by export - import division.

## Installation

At first you need to change some connection configuration inorder to connect the web<br>app into the SQL database. Find a file named 'config.php' in 'includes' folder. then<br>change the 4 lines that describes the connection.

> \$servername = "localhost"; <br> \$username = "root"; <br> \$password = ""; <br> \$dbname = "merck_shipment";

### On Local server

To Run it locally you only need a browser and XAMPP
You can download and install it by<br>clicking these sites below

- Chrome : [Download Chrome](https://support.google.com/chrome/answer/95346?co=GENIE.Platform%3DDesktop&hl=id)
- XAMPP : [Download XAMPP](https://www.apachefriends.org/download.html)

1. Copy the source code file into htdocs
2. Run Your local server by running XAMPP
3. After Opening XAMPP you should Start Apache and MySQL
4. Open your browser, and head to [localhost](localhost/phpmyadmin/)
5. Then import 'm_shipment.sql' into your local database

### On Live server

To run this web app in live server, you must've had the server and domain first. Once you<br>had it you can intall it by following these steps below.

1. Upload the source code file into the file manager you had in your server (account)
2. Import 'm_shipment.sql' database into your PHPMyAdmin page in CPanel

## UI Design and Typhography

This Web application was made for use by Merck Indonesia, therefore the developer wanted<br>to make Merck branding resembled in the web application design. The developer used some<br>of the assets from 'Liquid Design System' design kit downloaded from [merck.design](https://www.merck.design/)

## Built with

- Language - Native PHP 7.2
- PHP Library - DOMPDF
- PHP Library - PHPSpreadsheet
- Language - HTML
- Language - CSS
- Language - JS
- JS Library - Chart.js
- DBMS - MySQL

This web made with PHP Native, which made the code is a little bit hard to develop in the<br>future. The developer of this web suggest to made this source code implemented into PHP<br>framework such as Laravel or etc.

## Release History

- 1.0.0
  - Released for testing by Merck Indonesia Export-Import Division
- 1.0.1
  - Input existing data & quotation marks fixed
- 1.0.2
  - Missing recieved invoice date input fixed
  - Message box performance improvement
  - Several number input changed from integer into decimals
  - Add report state restructured
  - Input form UI changed (mandatory field, charge remark field)

## Author

- [Daffa Arrafi](https://github.com/daffaarravi)
