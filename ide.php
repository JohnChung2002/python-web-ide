<!DOCTYPE html>
<html>
<head>
    <title>Python Online Interpreter</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/python/python.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Python Online Interpreter</a>
        </div>
    </nav>
    <div class="container">
        <div id="code-mirror" class=" border rounded my-4">
            <textarea name="pycode" id="pycode-editor" cols="30" rows="10"></textarea>
        </div>
        <div class="d-grid gap-2">
          <button type="button" class="btn btn-primary" onclick='runCode()'>Run Code</button>
        </div>
        <div id="output" class="border rounded my-4 py-3 px-5">
            <h4><u>Output</u></h4>
        </div>
    </div>
    <script>
        function runCode() {
            dockerExecuteCode().then(function(data) { 
                document.getElementById("output").innerHTML = `<h4><u>Output</u></h4>${data}`;
            }).catch(err => console.log(err));
        }

        function dockerExecuteCode() {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    type: "GET",
                    url: "docker.php",
                    data: {
                        pycode: myCodeMirror.getValue()
                    },
                    success: function (result) {
                        resolve(result);
                    },
                    error: function (result) {
                        reject(result);
                    }
                });
            })
        }
        var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("pycode-editor"), {
            mode: "python",
            lineNumbers: true
        });
        myCodeMirror.setValue("print('Hello World')\n");
    </script>
</body>
</html>