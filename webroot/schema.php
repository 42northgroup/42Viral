<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Build the database</title>
  <style>
    ::-moz-selection { background: #fe57a1; color: #fff; text-shadow: none; }
    ::selection { background: #fe57a1; color: #fff; text-shadow: none; }
    html { padding: 30px 10px; font-size: 16px; line-height: 1.4; color: #737373; background: #f0f0f0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
    html, input { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; }
    body { max-width: 700px; _width: 700px; padding: 30px 20px 50px; border: 1px solid #b3b3b3; border-radius: 4px; margin: 0 auto; box-shadow: 0 1px 10px #a7a7a7, inset 0 1px 0 #fff; background: #fcfcfc; }
    h1 { margin: 0 10px; font-size: 50px; text-align: center; }
    h1 span { color: #bbb; }
    h3 { margin: 1.5em 0 0.5em; }
    p { margin: 1em 0; }
    ul { padding: 0 0 0 40px; margin: 1em 0; }
    .container { max-width: 580px; _width: 580px; margin: 0 auto; }
    dl{font-size: 14px;}
    pre {
        color: #000;
        background: #f0f0f0;
        padding: 15px;
        box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }
    pre,
    code{
        overflow: scroll;
        font-size: 12px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Build the database</h1>
        Run the schema shell from your CakePHP Console
        <pre>
            <code>
                cd app
                chmod +x Console/cake
                sudo ./Console/cake schema create
            </code>
        </pre>
        <a href="/setup">I have ran the schema shell</a>
  </div>


