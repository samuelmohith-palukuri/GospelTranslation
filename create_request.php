<html>
<head>
<title>Create a translation request</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script type="text/javascript">
  
  function validateForm(){

    var lang_src = document.forms["request_form"]["input_source_lang"].value;
    var lang_target = document.forms["request_form"]["input_target_lang"].value;
    
    if(lang_src == "..." || lang_target == "..."){

      var error_logging = document.getElementById("error_message_pane");
                      
      error_logging.style.visibility="visible";

      return false;
    }

    return true;

  }


</script>

<?php 

  require_once 'php/GospelTranslator.php';

  $translation = new GospelTranslator;

?>

</head>
<body style="background-image: url('src/img/body_bg.png');">

</br>
</br>

<h4 align="center">Create a translation request</h4>

</br>
</br>


<form name="request_form" align="center" class="col-lg-6 offset-lg-3" method="POST" action="save_request.php" onsubmit="return validateForm()">

  <div id="error_message_pane" style="visibility: hidden" class="alert alert-danger" role="alert">
    Please choose a valid source and target language.
  </div>

  <div class="form-group row justify-content-center">
      <label for="inputState">Translate from:</label>
      <select id="input_source_lang" name="source_lang" required class="form-control">
        <option>...</option>

        <?php 

          foreach($translation->getLang() as $lang) {
              echo "<option>" . $lang['languageName'] . "</option>";
          }

        ?>

      </select>
  </div>
  <div class="form-group row justify-content-center">
      <label for="inputState">Translate to:</label>
      <select id="input_target_lang" name="target_lang" required class="form-control">
        <option>...</option>
        <?php 

          foreach($translation->getLang() as $lang) {
              echo "<option>" . $lang['languageName'] . "</option>";
          }

        ?>
      </select>
  </div>

  <div class="form-group row justify-content-center">
    <label for="exampleFormControlTextarea1">Please enter the text to be translated:</label>
    <textarea required class="form-control" name="text_translation" id="exampleFormControlTextarea1" rows="10"></textarea>
  </div>

   <div class="form-group row justify-content-center">
    <label for="exampleFormControlTextarea1">Note/ additional information to the translator:</label>
    <textarea class="form-control" name="text_note" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>

  
  <div class="form-group">
    <input required type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">I agree to the terms and conditions.</label>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>

</form>

</body>
</html>