<div id="treeMenu" class="treeMenu col p-1 flex-grow-0 d-flex justify-content-between bg-black bg-opacity-25">
    <a href="javascript:;"
       onclick="app.initMainMenu(1)"
       title="Развернуть дерево">
        <i class="fa fa-fw fa-arrow-circle-down"></i>
    </a>

    <a href="javascript:;"
       onclick="modx.tree.collapseTree();"
       title="Свернуть дерево">
        <i class="fa fa-fw fa-arrow-circle-up"></i>
    </a>

    <a href="javascript:;"
       onclick="modx.tabs({url:'http://evo3x-git-ce.local/manager/?a=4', title: 'Новый ресурс'});"
       title="Новый ресурс">
        <i class="fa fa-fw fa-file"></i>
    </a>

    <a href="javascript:;"
       onclick="modx.tabs({url:'http://evo3x-git-ce.local/manager/?a=72', title: 'Новая ссылка'});"
       title="Новая ссылка">
        <i class="fa fa-fw fa-link"></i>
    </a>

    <a href="javascript:;"
       onclick="modx.tree.restoreTree();"
       title="Обновить дерево">
        <i class="fa fa-fw fa-refresh"></i>
    </a>

    <a href="javascript:;"
       onclick="modx.tree.showSorter(event);"
       title="Сортировать дерево">
        <i class="fa fa-fw fa-sort"></i>
    </a>

    <a href="javascript:;"
       onclick="modx.tabs({url: 'http://evo3x-git-ce.local/manager/?a=56&amp;id=0', title: 'Сортировать по позиции в меню'});"
       title="Сортировать по позиции в меню">
        <i class="fa fa-fw fa-sort-numeric-asc"></i>
    </a>

    <a href="javascript:;"
       title="Изображения
(Shift + клик, чтобы открыть несколько окон)">
        <i class="fa fa-fw fa-camera"></i>
    </a>

    <a href="javascript:;"
       title="Файлы
(Shift + клик, чтобы открыть несколько окон)">
        <i class="fa fa-file"></i>
    </a>

    <a href="javascript:;"
       title="Элементы
(Shift + клик, чтобы открыть несколько окон)">
        <i class="fa fa-fw fa-th"></i>
    </a>

    <a href="javascript:;"
       title="Нет ресурсов, помеченных на удаление.">
        <i class="fa fa-fw fa-trash"></i>
    </a>

    <a href="javascript:;"
       onclick="modx.tree.toggleTheme(event)"
       title="Переключатель цветовой схемы: 4 схемы">
        <i class="fa fa-fw fa-adjust"></i>
    </a>
</div>
<div class="col flex-grow-1">
    <div class="h-100 overflow-auto">

    </div>
</div>
