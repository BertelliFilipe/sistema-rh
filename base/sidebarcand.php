<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$id_cand = isset($_SESSION['id_cand']) ? $_SESSION['id_cand'] : 0; // ID do usuário logado
$nivel = isset($_SESSION ['nivel']) ? $_SESSION['nivel'] : null; // Nível de acesso do usuário
?>
<div class="logo-details">
      <i class='bx bxl-c-plus-plus'></i>
      <span class="logo_name">Grupo Triunfo</span>
    </div>
    <ul class="nav-links">      
      <li>
        <div class="iocn-link">
          <a href="?page=lista2_ficha">
            <i class='bx bx-id-card'></i>
            <span class="link_name">Candidatos</span>
          </a>
          <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">                  
        <li><a href="?page=lista2_ficha&id_cand=<?php echo $id_cand > 0 ? $id_cand : '0'; ?>">Minha Ficha</a></li>
        
        </ul>
      </li>