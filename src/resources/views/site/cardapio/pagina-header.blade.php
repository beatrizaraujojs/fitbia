   <section class="pagina-header">
       <div class="blob-pagina"></div>
       <div class="container header-interno">
           <span class="subtitulo">MENU COMPLETO</span>
           <h1 class="titulo-pagina">Escolha sua <span class="destaque">Rotina Saudável</span></h1>
           <p class="desc-pagina">Navegue por nossas categorias e monte o seu pedido. Tudo ultracongelado para manter 100% dos nutrientes e do sabor.</p>
         

               <form action="{{ route('site.cardapio') }}" method="GET" class="pesquisa-box">
                   <i class="ph ph-magnifying-glass"></i>

                   <input type="text" name="busca" placeholder="O que você quer comer hoje?" value="{{ request('busca') }}">

                   <button type="submit" style="display: none;">Buscar</button>
               </form>

          

       </div>



   </section>