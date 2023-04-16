<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
  </head>
  <style>
    nav ul {
      margin: 0;
      padding: 0;
      list-style: none;
      background-color: blue;
    }

    nav ul li {
      display: inline-block;
      position: relative;
    }

    nav ul li a {
      display: block;
      padding: 10px;
      color: white;
      font-size: 16px;
      text-decoration: none;
    }

    nav ul li:hover {
      background-color: #8468d8;
    }

    nav ul ul {
      display: none;
      position: absolute;
      top: 100%;
    }

    nav ul ul li {
      display: block;
    }

    nav ul ul li a {
      padding: 10px;
      color: #fff;
      font-size: 14px;
      text-decoration: none;
    }

    nav ul ul ul {
      position: absolute;
      left: 100%;
      top: 0;
    }

    nav ul li:hover > ul {
      display: inherit;
    }

    nav ul ul li:hover > ul {
      display: inherit;
    }

    @media only screen and (max-width: 768px) {
      nav ul {
        display: none;
        position: absolute;
        top: 60px;
        left: 0;
        width: 100%;
      }

      nav ul li {
        display: block;
        width: 100%;
      }

      nav ul li a {
        display: block;
        border-bottom: 1px solid #fff;
      }

      .menu-icon {
        display: inline-block;
        position: absolute;
        top: 0;
        right: 0;
        color: #fff;
        padding: 10px;
        cursor: pointer;
      }

      .menu-icon:hover {
        background-color: #555;
      }

      #menu:checked ~ nav ul {
        display: block;
      }
    }
  </style>
  <body>
    <nav>
      <ul>
        <li>
          <a href="#">MASTERS</a>
          <ul>
            <li>
              <a href="createsupplier.php" target="myframe">Create Supplier</a>
              <ul></ul>
            </li>
            <li>
              <a href="taxmaster.php" target="myframe">Tax Master</a>
              <ul>
                
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a href="#">TRANSACTIONS</a>
          <ul>
            <li>
              <a href="purchaseorder.php" target="myframe">Purchase Order </a>
              <ul>
               </ul>
            </li>
            <li>
              <a href="goods_receipt.php" target="myframe">Goods Receipt</a>
              <ul>
                
              </ul>
            </li>
            <li>
              <a href="soi.php" target="myframe">Supplier Order Invoice</a>
              <ul>
               
              </ul>
            </li>
          </ul>
        </li>
        <li><a href="#">Procecing</a>
        <ul>
            <li>
              <a href="payment.php" target="myframe">Payment </a>
              <ul>
               </ul>
            </li>
            <li>
              
              <ul>
                
              </ul>
            </li>
            <li>
       </li>
        <li><a href="#">Report</a></li>
      </ul>
    </nav>
    <iframe
      name="myframe"
      width="1500vw"
      height="1000vh"
      style="background-color: #e0dde9"
    ></iframe>
  </body>
</html>
