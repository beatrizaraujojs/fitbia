<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Fit Bia</title>
    
    <link rel="stylesheet" href="{{ asset('fitbia/css/dashboard.css') }}">
    
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>



    <div class="dash-container">
        
        <aside class="sidebar">
            <div class="sidebar-logo">
                <h2>Fit Bia</h2>
                <button id="btn-fechar-menu" class="btn-fechar-menu" aria-label="Fechar Menu">
                    <i class="ph ph-x"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav"> 
                <a href="#" class="active"><i class="ph ph-squares-four"></i> Visão Geral</a>
               <a href="{{ route('admin.categoria.index') }}"><i class="ph ph-tag"></i> Categorias</a>
                <a href="{{ route('admin.produto.index') }}"><i class="ph ph-package"></i> Produtos</a>
                <a href="#"><i class="ph ph-plus-circle"></i> Grupos Adicionais</a>
                
                <a href="#"><i class="ph ph-receipt"></i>Adicionais</a>
            </nav>
            <div class="sidebar-footer">
                <a href="#"><i class="ph ph-sign-out"></i> Sair do Sistema</a>
            </div>
        </aside>

        <main class="main-content">
            
            <header class="dash-header">
                <div class="header-left">
                    <button id="btn-menu-mobile" class="btn-menu-mobile" aria-label="Abrir Menu">
                        <i class="ph ph-list"></i>
                    </button>
                    <h1>Dashboard</h1>
                </div>
                
                <div class="user-profile">
                    <span>Olá, Administrador</span>
                    <i class="ph ph-user-circle"></i>
                </div>
            </header>

            <section class="content-area">
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Total de Pedidos</h3>
                        <p class="stat-number">24</p>
                    </div>
                    <div class="stat-card">
                        <h3>Produtos Ativos</h3>
                        <p class="stat-number">150</p>
                    </div>
                    <div class="stat-card">
                        <h3>Categorias</h3>
                        <p class="stat-number">8</p>
                    </div>
                </div>

            </section>
        </main>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const btnMenuMobile = document.getElementById("btn-menu-mobile");
        const btnFecharMenu = document.getElementById("btn-fechar-menu"); // Novo botão
        const sidebar = document.querySelector(".sidebar");

        // Abre o menu
        if(btnMenuMobile && sidebar) {
            btnMenuMobile.addEventListener("click", () => {
                sidebar.classList.add("aberta");
            });
        }

        // Fecha o menu
        if(btnFecharMenu && sidebar) {
            btnFecharMenu.addEventListener("click", () => {
                sidebar.classList.remove("aberta");
            });
        }
    });
</script>

</body>
</html>