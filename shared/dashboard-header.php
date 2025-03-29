<div class="header-content left">
<?php 
echo "<h1>$title</h1>";
echo "<h2>$subtitle</h2>";
?>
</div>
<div class="header-content right">
    <a href="profile.php">
        <div class="profile-icon">
            <?php 
                $initial = $_SESSION['first_name'][0].$_SESSION['last_name'][0];
                echo $initial;
            ?>
        </div>
    </a>
</div>

<style>

.header-content.left {
    flex: 85%;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    flex-direction: column;
    text-align: left;
    gap: 0px;
}

.header-content.right {
    flex: 15%;
    display: flex;
    align-items: center;
    justify-content: right;
}

.header-content.right a {
    text-decoration: none;
}

.header-content h2 {
    font-weight: 100;
    color:rgb(145, 145, 145);
    font-size: 1.4em;
}

.header-content .profile-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(90deg, #2F89FC 0%, #30E3CA 80%);;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 26px;
    font-weight: bold;
    border: 0px solid white;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.25);
    user-select: none;
    cursor: pointer;
}

@media screen and (max-width: 600px) {
    .header-content h1 {
        font-size: 1.7em;
    }

    .header-content h2 {
        font-size: 1.2em;
    }
}


</style>