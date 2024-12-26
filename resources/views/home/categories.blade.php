<style>
/* Container principal */
.categories-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap; /* Permite que itens fiquem em várias linhas se necessário */
    margin: 10px 0;
    gap: 16px; /* Espaço entre os itens */
}

/* Estilo de cada item de categoria */
.category-item {
    text-align: center;
    max-width: 150px; /* Limita a largura de cada item */
}

/* Estilo da imagem */
.category-image {
    width: 100px;
    height: 100px;
    border-radius: 50%; /* Faz a imagem ficar redonda */
    object-fit: cover; /* Garante que a imagem não fique distorcida */
    margin: 0 auto 10px auto; /* Centraliza e adiciona espaçamento abaixo */
    border: 2px solid #ccc; /* Opcional: borda ao redor da imagem */
}

/* Estilo do título */
.category-title {
    font-size: 1rem;
    color: #333;
    font-family: 'Mono';
}
#categoriesTitle {
    margin: 50px 20px 40px 20px;
    padding-left:40px;
    font-size: 2rem;
    font-weight: bold;
    font-family: 'Montserrat';
}
</style>
<div class="max-w-7xl mx-auto py-8 px-4">
 <h1 class="text-2xl font-bold font-serif text-gray-900 mb-6" style="font-weight: bold;">Explore as Categorias</h1>
</div>

<div class="categories-container">
    @foreach ($categories as $index => $item)
    <div class="category-item">
        <img src="{{asset($images[$index])}}" alt="Categoria 1" class="category-image">
        <a href="/search/category/{{$item->id}}">
        <p class="category-title">{{$item->category_title}}</p>
        </a>
    </div>
    @endforeach

</div>
