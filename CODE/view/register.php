<h3>S'enregistrer sur le forum</h3>


<form action="index.php?ctrl=security&action=register" method="POST">
    
        <label for="pseudonyme">Pseudonyme :</label><br>
        <input type="text" id="pseudonyme" name="pseudonyme" placeholder="Pseudonyme" required><br><br>
    
        <label for="email">Email :</label><br>
        <input type="email" id="email" name="email" placeholder="Email valide" required><br><br>
    
        <label for="pass1">Mot de passe :</label><br>
        <input type="password" id="pass1" name="pass1" placeholder="Mot de passe" required><br><br>
    
        <label for="pass2">Confirmation du mot de passe :</label><br>
        <input type="password" id="pass2" name="pass2" placeholder="Mot de passe identique" required><br><br>
    
        <input type="submit" name="submit" value="Submit"><br><br>
    
</form>


