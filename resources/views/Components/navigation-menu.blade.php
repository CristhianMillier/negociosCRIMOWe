<nav class="sidebar-nav">
    <ul id="sidebarnav" class="pt-4 container-fluid">
        <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('panel') }}"
                aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a>
        </li>

        @can('ver-cliente')
        <li class="sidebar-item" id="cliente-li">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" id="cliente-a"
                href="{{ route('clientes.index') }}" aria-expanded="false"><i class="fa-solid fa-user-tag"></i><span
                    class="hide-menu">Clientes</span></a>
        </li>
        @endcan

        @can('ver-proveedor')
        <li class="sidebar-item" id="proveedore-li">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" id="proveedore-a"
                href="{{ route('proveedores.index') }}" aria-expanded="false"><i
                    class="fa-solid fa-truck-field"></i><span class="hide-menu">Proveedores</span></a>
        </li>
        @endcan

        @can('ver-producto')
        <li class="sidebar-item" id="producto-li">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" id="producto-a"
                href="{{ route('productos.index') }}" aria-expanded="false"><i class="fa-solid fa-cubes"></i><span
                    class="hide-menu">Productos</span></a>
        </li>
        @endcan

        @can('ver-marca')
        <li class="sidebar-item" id="marca-li">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" id="marca-a" href="{{ route('marcas.index') }}"
                aria-expanded="false"><i class="fa-solid fa-tags"></i><span class="hide-menu">Marcas</span></a>
        </li>
        @endcan

        @can('ver-categoria')
        <li class="sidebar-item" id="categoria-li">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" id="categoria-a"
                href="{{ route('categorias.index') }}" aria-expanded="false"><i
                    class="fa-solid fa-layer-group"></i><span class="hide-menu">Categorías</span></a>
        </li>
        @endcan

        @can('ver-compra')
        <li class="sidebar-item">
            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i
                    class="fa-solid fa-shop"></i><span class="hide-menu">Compras
                </span></a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item" id="ver-compra-li">
                    <a href="{{ route('compras.index') }}" class="sidebar-link"><i
                            class="fas fa-window-restore"></i><span class="hide-menu" id="ver-compra-a"> Ver Compras
                        </span></a>
                </li>
                <li class="sidebar-item" id="crear-compra-li">
                    <a href="{{ route('compras.create') }}" class="sidebar-link"><i class="fa-solid fa-store"></i><span
                            class="hide-menu" id="crear-compra-li">
                            Crear Compra
                        </span></a>
                </li>
            </ul>
        </li>
        @endcan

        @can('ver-venta')
        <li class="sidebar-item">
            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i
                    class="fa-brands fa-shopify"></i></i><span class="hide-menu">Ventas
                </span></a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item" id="ver-venta-li">
                    <a href="{{ route('ventas.index') }}" class="sidebar-link"><i class="fa-solid fa-receipt"></i><span
                            class="hide-menu" id="ver-venta-a"> Ver Ventas
                        </span></a>
                </li>
                <li class="sidebar-item" id="crear-venta-li">
                    <a href="{{ route('ventas.create') }}" class="sidebar-link"><i
                            class="fa-solid fa-basket-shopping"></i><span class="hide-menu" id="crear-venta-li">
                            Crear Venta
                        </span></a>
                </li>
            </ul>
        </li>
        @endcan

        @can('ver-caja')
        <li class="sidebar-item" id="caja-li">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" id="caja-a" href="{{ route('cajas.index') }}"
                aria-expanded="false"><i class="fa-solid fa-cash-register"></i><span class="hide-menu">Caja</span></a>
        </li>
        @endcan

        @can('ver-usuario')
        <li class="sidebar-item" id="user-li">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('users.index') }}"
                aria-expanded="false" id="user-a"><i class="fa-solid fa-users"></i><span
                    class="hide-menu">Usuarios</span></a>
        </li>
        @endcan

        @can('ver-rol')
        <li class="sidebar-item" id="role-li">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('roles.index') }}"
                aria-expanded="false" id="role-a"><i class="fa-solid fa-person-circle-plus"></i><span
                    class="hide-menu">Roles</span></a>
        </li>
        @endcan

        <li class="sidebar-item border-top">
            <a class="sidebar-link has-arrow waves-effect waves-dark d-flex" href="javascript:void(0)"
                aria-expanded="false"><i class="fa-solid fa-user-lock"></i></i><span
                    class="hide-menu container-fluid">Configuración
                </span></a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    <a href="{{route('profile.index')}}" class="sidebar-link"><i
                            class="mdi mdi-account me-1 ms-1"></i><span class="hide-menu"> Mi Perfil
                        </span></a>
                </li>
                <li class="sidebar-item">
                    <a href="{{route('logout')}}" class="sidebar-link"><i class="fa fa-power-off me-1 ms-1"></i><span
                            class="hide-menu" id="crear-venta-li">
                            Cerrar Sección
                        </span></a>
                </li>
            </ul>
        </li>
    </ul>
</nav>