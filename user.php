<?php 

  $title='users';
 require_once('includes/header.php');
 require_once('db/cnx.php');
   $nomf=isset($_GET['nom'])?$_GET['nom']:"";
   $relef=isset($_GET['role'])?$_GET['role']:"tous";
  $size=isset($_GET['size'])?$_GET['size']:4;
  $page=isset($_GET['page'])?$_GET['page']:1;
  $offset=($page-1)*$size;   
 if($relef=="tous"){

   $rqt = "select id,nom,prenom,email from user where nom LIKE '%$nomf%' limit $size offset $offset";
   
   
 }
 
 else{
  $rqt = "select nom,prenom,email from user where nom LIKE '%$nomf%' and role = '$relef' limit $size offset $offset";

 }
 $nbruser="select count(*) countu from user where nom LIKE '%$nomf%'";
 $resultat=$pdo->query($rqt);

 $nbuser=$pdo->query($nbruser);

$tablecount=$nbuser->fetch();
$user=$tablecount['countu'];

 $resu= $user % $size;
    if($resu==0) $nbrpage = $user/$size; 
 else{
  $nbrpage = floor($user/$size)+1;
 }
 $id;
 $editemod;
?>

<div class="container">
<div class="card">
  <div class="card-body">
  <form class="row g-3" methode="GET">
  
  <div class="col-auto">
  <input type="text" class="form-control" id="inputPassword2" placeholder="Nom" name="nom" value="<?php echo $nomf ?>">
  </div>

  <label for="role" class="col-auto">Role</label>
  <div class="col-auto">
  
  <select id="role" name="role" class="form-select form-control" onchange="this.form.submit()">
                <option value="tous"<?php if($relef=="tous") echo "selected"  ?>>Tous</option>
                <option value="admin"<?php if($relef=="admin") echo "selected"?>>Admin</option>
                <option value="visiteur" <?php if($relef=="visiteur") echo "selected"?>>Visiteur</option>
            </select>
  </div>
  
  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-12"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
</svg>

  </button>
  </div>

</form>
  </div>
</div>
<style>
.sa{
  float:right;
};
.re{
 color: red;
}
</style>
<div class="card">
  <div class="card-header">
   users 

   <div class="card-tools sa" >
   <button class="btn btn-success"data-bs-toggle="modal" data-bs-target="#addn">
     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
  <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
  <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
</svg>
       add new</button>

  </div>
  </div>
 
  <div class="card-body">

    <p class="card-text">
        <table class="table table-striped">
       <thead>
            <tr>
                <th>nom</th>
                <th>prenom</th>
                <th>email</th>
                <th>modification</th>
            </tr>

       </thead>
         <tbody>
             <?php while($bo=$resultat->fetch()) {?>
             <tr>
                 <td> <?php echo $bo['nom'] ?> </td>
                 <td> <?php echo $bo['prenom'] ?> </td>
                 <td> <?php echo $bo['email'] ?> </td>
                  <td>
                    <a href="" style='font-size:48px;color:red' data-bs-toggle="modal" data-bs-target="#uppn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
  <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
  <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
</svg>
                    </a>
                  
                  <a href="supprimer.php id=<?php echo $bo['id']; ?>  " style='font-size:48px;color:blue'>
                    
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-x-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
</svg>
                  </a>
                  </td>
            </tr>
            <?php } ?>
         </tbody>

        </table>
       <div >
         <ul class="pagination">
           
           <?php for($i=1;$i<=$nbrpage;$i++) {?>
               <li class="page-item <?php if($i==$page) echo 'active'; ?>">
                 <a  href="user.php?page=  <?php echo $i; ?> " class="page-link" >
                   <?php echo $i; ?> 

                 </a>

               </li>
           <?php } ?>
         </ul>
       
      </div>




    </p>
  
  </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="addn" tabindex="-1" aria-labelledby="addnLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addnLabel"> AJOUTER NOUVELLE UTILISATEUR</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form  method="POST" action="insert.php" class="form">

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
  <label for="ville">Votre ville</label>
  <input type="text" name="ville" class="form-control" id="ville" placeholder="ville">
 
</div>

<div class="form-group">
 
  <input type="hidden" name="etat" class="form-control" id="etat" placeholder="etat">
  <small id="etat"  class="form-text text-muted">votre etat stp</small>
</div>


<div class="form-group">
  <label for="email">Votre Email</label> 
  <input type="Email"  name="email" class="form-control" id="email" aria-describedby="emailHelp">
  <small id="email"class="form-text text-muted">votr nom stp</small>
</div>


 <label for="role" class="col-auto">Role</label>
  <div class="col-auto form-group">
  
  <select id="role" name="role" class="form-select form-control">
                <option value="admin">Admin</option>
                <option value="visiteur"selected>Visiteur</option>
            </select>
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
<div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
      </div>

      </form>
</div>
      
    </div>
  </div>
</div>
<!-- update -->
<div class="modal fade" id="uppn" tabindex="-1" aria-labelledby="uppnLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uppnLabel"> uppp</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form  method="POST" action="update.php" class="form">

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
  <label for="ville">Votre ville</label>
  <input type="text" name="ville" class="form-control" id="ville" placeholder="ville">
 
</div>

<div class="form-group">
 
  <input type="hidden" name="etat" class="form-control" id="etat" placeholder="etat">
  <small id="etat"  class="form-text text-muted">votre etat stp</small>
</div>


<div class="form-group">
  <label for="email">Votre Email</label> 
  <input type="Email"  name="email" class="form-control" id="email" aria-describedby="emailHelp">
  <small id="email"class="form-text text-muted">votr nom stp</small>
</div>


 <label for="role" class="col-auto">Role</label>
  <div class="col-auto form-group">
  
  <select id="role" name="role" class="form-select form-control">
                <option value="admin">Admin</option>
                <option value="visiteur"selected>Visiteur</option>
            </select>
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
<div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
      </div>

      </form>
</div>
      
    </div>
  </div>
</div>
<?php require_once('includes/footer.php') ?>