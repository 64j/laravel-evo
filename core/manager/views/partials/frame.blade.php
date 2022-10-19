<div class="col flex-grow-0 bg-dark">
    <div class="tabs-row d-flex flex-nowrap bg-black bg-opacity-25 overflow-auto">
        <a href="{{ $homeTab }}" class="tab-home d-block p-1 px-2 active" target="main">
            <i class="fa fa-fw fa-home mx-1"></i>
        </a>
    </div>
</div>
<div class="col flex-grow-1 position-relative w-100 h-100 overflow-hidden">
    <iframe src="{{ $homeTab }}" name="main" class="position-absolute top-0 start-0 w-100 h-100 overflow-auto"></iframe>
</div>
