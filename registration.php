  <?php
  $title = 'registration';
  require_once('includes/header.php') ;
  require_once('db/cnx.php');
  ?>
  
    <h1 class="text-center">salut, enregistrer vous!</h1>

    <form action="" methode="POST">

  <div class="form-group">
    <label for="nom">Votre nom</label>
    <input type="text" name="nom" class="form-control" id="nom" placeholder="nom">
    <small id="nom"  class="form-text text-muted">votre nom stp</small>
  </div>

  <div class="form-group">
    <label for="prenom">Votre prenom</label>
    <input type="text" name="prenom" class="form-control" id="prenom" placeholder="prenom">
    <small id="prenom"  class="form-text text-muted">votre prenom stp</small>
  </div>

  <div class="form-group">
    <label for="adresse">Votre adresse</label>
    <input type="text"  name="adresse" class="form-control" id="adresse" placeholder="votre_adresse">
    <small id="adresse"  class="form-text text-muted">votre adresse stp</small>
  </div>

  <div class="form-group">
    <label for="email">Votre Email</label> 
    <input type="Email"  name="email" class="form-control" id="email" aria-describedby="emailHelp">
    <small id="email"class="form-text text-muted">votr nom stp</small>
  </div>


  <div class="form-group">
  <label for="ville">Votre ville</label>
  <select class="form-select" aria-label="Default select example" name="ville">
  <option selected>Votre ville</option>
  <option value="1">Casablanca</option>
  <option value="2">Rabat</option>
  <option value="3">Eljadia</option>
</select>
<small id="ville"  class="form-text text-muted">votre ville stp</small>
</div>

  <div class="form-group">
    <label for="date">Votre date Naissence</label>
    <input type="Date" name="date" class="form-control" id="date" placeholder="date">
    <small id="date"  class="form-text text-muted">votre date de naissence stp</small>
  </div>

 
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="pswd" class="form-control" id="exampleInputPassword1">
    <small id="emailHelp" class="form-text text-muted">votr paswd stp</small>
  </div>

  
    <button type="submit" name="submit" class="btn btn-primary form-control ">Confirm identity</button>

  
</form>

<?php
if(isset($_POST['submit'])){
 $nom=$_post['nom'];   
 $date=$_post['date'];
 $pswd=$_post['pswd'];
 $prenom=$_post['prenom'];
 $email=$_post['email'];
 $ville=$_post['ville'];
 $adresse=$_post['adresse'];
 $sql = "INSERT INTO user(nom,prenom,email,adresse,ville,pswd,date) VALUES (:nom,:prenom,:email,:adresse,:ville,:pswd,:date) ";
 $stm = $pdo->prepare($sql);
 $stm->execute(['nom'=>$nom,'prenom'=>$prenom,'email'=>$email,'ville'=>$ville,'pswd'=>$pswd,'date'=>$date,'adresse'=>$adresse]);
}

?>
    
<?php require_once('includes/footer.php') ?>
   