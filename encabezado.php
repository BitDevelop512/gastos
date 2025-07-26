  <link href="jquery/jquery1/jquery-ui.css" rel="stylesheet">
  <script src="jquery/jquery1/jquery.js"></script>
  <script src="jquery/jquery1/jquery-ui.js"></script>
  <script src="js/validnum.js" type="text/javascript" ></script>
  <script src="js/jquery.maskMoney.min.js" type="text/javascript"></script>
  <style>
  body
  {
    margin-top: 5px;
    margin-left: 20px;
    margin-bottom: 20px;
    margin-right: 20px;
    background: #f4f7f9;
  }
  input
  {
    background: #f8f8f8;
    padding: 4px;
  }
  input[type="radio"]
  {
    width: 20px;
    height: 20px;
  }
  input[type="checkbox"]
  {
    width: 15px;
    height: 15px;
  }
  .ui-widget
  {
    font-size: 13px;
  }
  .c0
  {
    text-align: center;
    width: 35px;
  }
  .c1
  {
    text-align: center;
    width: 90px;
  }
  .c2
  {
    width: 90px;
    text-align: right;
  }
  .c3
  {
    width: 200px;
  }
  .c4
  {
    width: 170px;
  }
  .c5
  {
    width: 120px;
  }
  .c6
  {
    width: 350px;
  }
  .c7
  {
    width: 120px;
    text-align: right;
  }
  .c8
  {
    width: 150px;
    text-align: right;
  }
  .c9
  {
    width: 400px;
  }
  .c10
  {
    width: 50px;
  }
  .c11
  {
    width: 450px;
  }
  .c12
  {
    width: 200px;
    text-align: right;
  }
  .c13
  {
    width: 50px;
    text-align: right;
  }
  .c14
  {
    width: 80px;
  }
  .c15
  {
    width: 550px;
  }
  .c16
  {
    width: 800px;
  }
  .c17
  {
    width: 300px;
  }
  .c18
  {
    width: 90px;
  }
  .c19
  {
    width: 140px;
    text-align: right;
  }
  .c20
  {
    width: 720px;
  }
  .c21
  {
    text-align: center;
    width: 15px;
  }
  .c22
  {
    width: 65px;
    text-align: right;
  }
  .c23
  {
    width: 60px;
    text-align: right;
  }
  .c24
  {
    width: 430px;
  }
  .c25
  {
    width: 200px;
    text-align: center;
  }
  .c26
  {
    width: 405px;
  }
  .espacio
  {
    padding-top: 10px;
    padding-bottom: 5px;
  }
  .espacio1
  {
    padding-top: 3px;
    padding-bottom: 3px;
  }
  .espacio2
  {
    padding: 5px;
  }
  .espacio3
  {
    padding-top: 8px;
    padding-bottom: 8px;
  }
  .espacio4
  {
    padding-top: 2px;
    padding-bottom: 2px;
  }
  .lista_sencilla1
  {
    display: block;
    width: 430px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla1:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla2
  {
    display: block;
    width: 210px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla2:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla3
  {
    display: block;
    width: 100px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla3:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla4
  {
    display: block;
    width: 300px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla4:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla5
  {
    width: 430px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla5:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla6
  {
    width: 100px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla6:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla7
  {
    width: 170px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla7:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla8
  {
    width: 210px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla8:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla9
  {
    display: block;
    width: 460px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla9:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla10
  {
    display: block;
    width: 350px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla10:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla11
  {
    display: block;
    width: 520px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla11:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla12
  {
    display: block;
    width: 250px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla12:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla13
  {
    width: 650px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla13:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla14
  {
    width: 380px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla14:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla15
  {
    width: 120px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla15:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla16
  {
    width: 80px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla16:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla17
  {
    width: 360px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla17:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla18
  {
    width: 250px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla18:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }

  .lista_sencilla19
  {
    width: 150px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla19:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla20
  {
    display: block;
    width: 360px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla20:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .lista_sencilla21
  {
    display: block;
    width: 135px;
    height: 30px;
    padding: 0px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  }
  .lista_sencilla21:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  #a-table tr:nth-child(even)
  {
    background: #cecece;
  }
  #a-table tr:hover
  {
    background-color: red;
    color: white;
    cursor: pointer;
  }
  #a-table a
  {
    text-decoration: none;
    color: inherit;
  }
  #a-table1 tr:nth-child(even)
  {
    background: #cecece;
  }
  #a-table tr:hover
  {
    color: white;
    cursor: pointer;
  }
  #a-table1 a
  {
    text-decoration: none;
    color: inherit;
  }
  #content
  {
    width: 95%;
    height: auto;
    margin: 0 auto;
  }
  #res_usua
  {
    height: 420px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 12px;
  }
  #tabla
  {
    height: 41px;
    font-family: 'Verdana';
    font-size: 11px;
  }
  #tabla1
  {
    height: 18px;
    font-family: 'Verdana';
    font-size: 11px;
  }
  #tabla2
  {
    height: 70px;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #tabla3
  {
    height: 54px;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #tabla4
  {
    height: 35px;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #tabla5
  {
    height: 54px;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #tabla6
  {
    height: 54px;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #tabla7
  {
    height: 121px;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #tabla8
  {
    height: 90px;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #tabla9
  {
    height: 18px;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #tabla10
  {
    height: 75px;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #tabla11
  {
    height: 54px;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #tabla12
  {
    height: 122px;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #tabla13
  {
    height: 54px;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #resultados
  {
    height: 165px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 12px;
  }
  #resultados1
  {
    height: 150px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 12px;
  }
  #resultados2
  {
    height: 240px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #resultados3
  {
    height: 150px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 12px;
  }
  #resultados4
  {
    height: 350px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #resultados5
  {
    height: 450px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #resultados6
  {
    height: 330px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #resultados7
  {
    height: 450px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #resultados8
  {
    height: 50px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #resultados9
  {
    height: 600px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 12px;
  }
  #resultados10
  {
    height: 350px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #resultados11
  {
    height: 350px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #resultados12
  {
    height: 400px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #resultados13
  {
    height: 350px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #resultados14
  {
    height: 350px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 13px;
  }
  #res_unic
  {
    height: 650px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 12px;
  }
  #res_conc
  {
    height: 230px;
    overflow: auto;
    font-family: 'Verdana';
    font-size: 12px;
  }
  .mas
  {
    cursor: pointer;
  }
  canvas
  {
    border: 1px dotted #000;
    cursor: pointer;
    margin-left: 20px;
    margin-right: 20px;
  }
  </style>