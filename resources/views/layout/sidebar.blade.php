@php
    $request = request();
@endphp
<div class="app-sidebar">
    <div class="scrollbar-sidebar">
        <div class="branding-logo">
            <img src="{{ $general_settings->logo->file ?? asset('/logo/logo.png') }}" alt="">
        </div>
        <div class="branding-logo-forMobile">
            <a href="{{ route('root') }}"><img
                    src="{{ isset($general_settings->smallLogo->file) && $general_settings->smallLogo->file ? $general_settings->smallLogo->file : asset('/logo/small_logo.png') }}"
                    alt=""></a>
        </div>
        <div class="app-sidebar-inner">
            <ul class="vertical-nav-menu">
                <li>
                    <a class="menu {{ $request->routeIs('root') ? 'active' : '' }}" href="{{ route('root') }}">
                        <span>
                            <img src="/icons/menu.svg" class="menu-icon" alt="icon" />
                            {{ __('dashboard') }}
                        </span>
                    </a>
                </li>
                @canany(['subscription.index'])
                    <li>
                        <a class="menu {{ $request->routeIs('subscription.*') ? 'active' : '' }}" data-bs-toggle="collapse"
                            href="#productMenu">
                            <span>
                                <img src="/icons/subscription.svg" class="menu-icon" alt="icon" />
                                {{ __('subscriptions') }}
                            </span>
                            <img src="/icons/arrowDown.svg" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('subscription.*') ? 'show' : '' }}"
                            id="productMenu">
                            <div class="listBar">
                                @can('subscription.index')
                                    <a href="{{ route('subscription.index') }}"
                                        class="subMenu {{ $request->routeIs('subscription.index') ? 'active' : '' }}">
                                        {{ __('list') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['subscription-purchase.index'])
                    <li>
                        <a class="menu {{ $request->routeIs('subscription-purchase.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#productMenu">
                            <span>
                                <img src="/icons/subscription.svg" class="menu-icon" alt="icon" />
                                {{ __('subscriptions') }}
                            </span>
                            <img src="/icons/arrowDown.svg" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('subscription-purchase.*') ? 'show' : '' }}"
                            id="productMenu">
                            <div class="listBar">
                                @can('subscription-purchase.index')
                                    <a href="{{ route('subscription-purchase.index') }}"
                                        class="subMenu {{ $request->routeIs('subscription-purchase.index') ? 'active' : '' }}">
                                        {{ __('list') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['category.index', 'product.index', 'barcode.print', 'brand.index', 'unit.index',
                    'warehouse.index'])
                    <li>
                        <a class="menu {{ $request->routeIs('category.*', 'product.*', 'barcode.print', 'warehouse.*', 'unit.*', 'brand.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#productMenu">
                            <span>
                                <img src="/icons/product.svg" class="menu-icon" alt="icon" />
                                {{ __('product') }}
                            </span>
                            <img src="/icons/arrowDown.svg" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('category.*', 'product.*', 'barcode.print', 'warehouse.*', 'unit.*', 'brand.*') ? 'show' : '' }}"
                            id="productMenu">
                            <div class="listBar">
                                @can('category.index')
                                    <a href="{{ route('category.index') }}"
                                        class="subMenu {{ $request->routeIs('category.index') ? 'active' : '' }}">
                                        {{ __('categories') }}
                                    </a>
                                @endcan
                                @can('product.index')
                                    <a href="{{ route('product.index') }}"
                                        class="subMenu {{ $request->routeIs('product.*') ? 'active' : '' }}">
                                        {{ __('products') }}
                                    </a>
                                @endcan
                                @can('barcode.print')
                                    <a href="{{ route('barcode.print') }}"
                                        class="subMenu {{ $request->routeIs('barcode.print') ? 'active' : '' }}">
                                        {{ __('print_barcode') }}
                                    </a>
                                @endcan
                                @can('unit.index')
                                    <a href="{{ route('unit.index') }}"
                                        class="subMenu {{ $request->routeIs('unit.index') ? 'active' : '' }}">{{ __('units') }}</a>
                                @endcan
                                @can('brand.index')
                                    <a href="{{ route('brand.index') }}"
                                        class="subMenu {{ $request->routeIs('brand.index') ? 'active' : '' }}">{{ __('brands') }}</a>
                                @endcan
                                @can('warehouse.index')
                                    <a href="{{ route('warehouse.index') }}"
                                        class="subMenu {{ $request->routeIs('warehouse.index') ? 'active' : '' }}">{{ __('warehouses') }}</a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['shop.category.index'])
                    <li>
                        <a class="menu {{ $request->routeIs('shop.category.*') ? 'active' : '' }}" data-bs-toggle="collapse"
                            href="#shopCategoryMenu">
                            <span>
                                <img src="/icons/product.svg" class="menu-icon" alt="icon" />
                                {{ __('shop') }}
                            </span>
                            <img src="/icons/arrowDown.svg" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('shop.category.*') ? 'show' : '' }}"
                            id="shopCategoryMenu">
                            <div class="listBar">
                                @can('shop.category.index')
                                    <a href="{{ route('shop.category.index') }}"
                                        class="subMenu {{ $request->routeIs('category.index') ? 'active' : '' }}">
                                        {{ __('categories') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['purchase.index', 'purchase.create', 'stockCount.index', 'purchase.batch'])
                    <li>
                        <a class="menu {{ $request->routeIs('purchase.*', 'stockCount.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#purchaseMenu">
                            <span>
                                <img src="/icons/purchase.svg" class="menu-icon" alt="icon" />
                                {{ __('purchase') }}
                            </span>
                            <img src="/icons/arrowDown.svg" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('purchase.*', 'stockCount.*') ? 'show' : '' }}"
                            id="purchaseMenu">
                            <div class="listBar">
                                @can('purchase.index')
                                    <a class="subMenu {{ $request->routeIs('purchase.index', 'purchase.edit') ? 'active' : '' }}"
                                        href="{{ route('purchase.index') }}">{{ __('purchases') }}</a>
                                @endcan
                                @can('purchase.create')
                                    <a class="subMenu {{ $request->routeIs('purchase.create') ? 'active' : '' }}"
                                        href="{{ route('purchase.create') }}">{{ __('add_purchase') }}</a>
                                @endcan
                                @can('stockCount.index')
                                    <a class="subMenu {{ $request->routeIs('stockCount.index') ? 'active' : '' }}"
                                        href="{{ route('stockCount.index') }}">{{ __('stock_count') }}</a>
                                @endcan
                                @can('purchase.batch')
                                    <a class="subMenu {{ $request->routeIs('purchase.batch') ? 'active' : '' }}"
                                        href="{{ route('purchase.batch') }}">{{ __('batches') }}</a>
                                @endcan

                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['account.index', 'moneyTransfer.index', 'account.balancesheet'])
                    <li>
                        <a class="menu {{ $request->routeIs('account.*', 'moneyTransfer.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#accountMenu">
                            <span>
                                <img src="/icons/account.svg" class="menu-icon" alt="icon" />
                                {{ __('accounting') }}
                            </span>
                            <img src="/icons/arrowDown.svg" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('account.*', 'moneyTransfer.*') ? 'show' : '' }}"
                            id="accountMenu">
                            <div class="listBar">
                                @can('account.index')
                                    <a href="{{ route('account.index') }}"
                                        class="subMenu {{ $request->routeIs('account.index') ? 'active' : '' }}">{{ __('accounts') }}</a>
                                @endcan
                                @can('moneyTransfer.index')
                                    <a href="{{ route('moneyTransfer.index') }}"
                                        class="subMenu {{ $request->routeIs('moneyTransfer.index') ? 'active' : '' }}">
                                        {{ __('money_transfer') }}
                                    </a>
                                @endcan
                                @can('account.balancesheet')
                                    <a href="{{ route('account.balancesheet') }}"
                                        class="subMenu {{ $request->routeIs('account.balancesheet') ? 'active' : '' }}">
                                        {{ __('balance_sheet') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['sale.index', 'sale.draft'])
                    <li>
                        <a class="menu {{ $request->routeIs('sale.*') ? 'active' : '' }}" data-bs-toggle="collapse"
                            href="#saleMenu">
                            <span>
                                <img src="/icons/sales.svg" class="menu-icon" alt="icon" />
                                {{ __('sales') }}
                            </span>
                            <img src="/icons/arrowDown.svg" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('sale.*') ? 'show' : '' }}"
                            id="saleMenu">
                            <div class="listBar">
                                @can('sale.index')
                                    <a href="{{ route('sale.index') }}"
                                        class="subMenu {{ $request->routeIs('sale.index') ? 'active' : '' }}">
                                        {{ __('sales') }}
                                    </a>
                                @endcan
                                @can('sale.draft')
                                    <a href="{{ route('sale.draft') }}"
                                        class="subMenu {{ $request->routeIs('sale.draft') ? 'active' : '' }}">
                                        {{ __('drafts') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['sale_returns.index'])
                    <li>
                        <a class="menu {{ $request->routeIs('sale_returns.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#saleReturnsMenu">
                            <span>
                                <img src="/icons/return.svg" class="menu-icon" alt="icon" />
                                {{ __('returns') }}
                            </span>
                            <img src="/icons/arrowDown.svg" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('sale_returns.*') ? 'show' : '' }}"
                            id="saleReturnsMenu">
                            <div class="listBar">
                                @can('sale_returns.index')
                                    <a href="{{ route('sale_returns.index') }}"
                                        class="subMenu {{ $request->routeIs('sale_returns*') ? 'active' : '' }}">
                                        {{ __('sales') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['expenseCategory.index', 'expense.index'])
                    <li>
                        <a class="menu {{ $request->routeIs('expenseCategory.*', 'expense.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#expenseMenu">
                            <span>
                                <img src="/icons/profit.svg" class="menu-icon" alt="icon" />
                                {{ __('expense') }}
                            </span>
                            <img src="/icons/arrowDown.svg" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('expenseCategory.*', 'expense.*') ? 'show' : '' }}"
                            id="expenseMenu">
                            <div class="listBar">
                                @can('expenseCategory.index')
                                    <a href="{{ route('expenseCategory.index') }}"
                                        class="subMenu {{ $request->routeIs('expenseCategory.*') ? 'active' : '' }}">
                                        {{ __('expense_category') }}
                                    </a>
                                @endcan
                                @can('expense.index')
                                    <a href="{{ route('expense.index') }}"
                                        class="subMenu {{ $request->routeIs('expense.*') ? 'active' : '' }}">
                                        {{ __('expense') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['user.index', 'customer.index', 'supplier.index', 'role.index', 'customer_group.index'])
                    <li>
                        <a class="menu {{ $request->routeIs('user.*', 'customer.*', 'supplier.*', 'role.*', 'customer_group.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#peopleMenu">
                            <span>
                                <img src="/icons/users.svg" class="menu-icon" alt="icon" />
                                {{ __('people') }}
                            </span>
                            <img src="/icons/arrowDown.svg" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('user.*', 'customer.*', 'supplier.*', 'role.*', 'customer_group.*') ? 'show' : '' }}"
                            id="peopleMenu">
                            <div class="listBar">
                                @can('user.index')
                                    <a href="{{ route('user.index') }}"
                                        class="subMenu {{ $request->routeIs('user.*') ? 'active' : '' }}">
                                        {{ __('users') }}
                                    </a>
                                @endcan
                                @can('role.index')
                                    <a href="{{ route('role.index') }}"
                                        class="subMenu {{ $request->routeIs('role.*') ? 'active' : '' }}">
                                        {{ __('role_permission') }}
                                    </a>
                                @endcan
                                @can('customer.index')
                                    <a href="{{ route('customer.index') }}"
                                        class="subMenu {{ $request->routeIs('customer.*') ? 'active' : '' }}">
                                        {{ __('customers') }}
                                    </a>
                                @endcan
                                @can('customer_group.index')
                                    <a href="{{ route('customer_group.index') }}"
                                        class="subMenu {{ $request->routeIs('customer_group.index') ? 'active' : '' }}">{{ __('customer_groups') }}</a>
                                @endcan
                                @can('supplier.index')
                                    <a href="{{ route('supplier.index') }}"
                                        class="subMenu {{ $request->routeIs('supplier.*') ? 'active' : '' }}">
                                        {{ __('suppliers') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['report.summary'])
                    <li>
                        <a class="menu {{ $request->routeIs('report.*') ? 'active' : '' }}" data-bs-toggle="collapse"
                            href="#reportMenu">
                            <span>
                                <img src="/icons/report.svg" class="menu-icon" alt="icon" />
                                {{ __('reports') }}
                            </span>
                            <img src="/icons/arrowDown.svg" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('report.*') ? 'show' : '' }}"
                            id="reportMenu">
                            <div class="listBar">
                                @can('report.summary')
                                    <a href="{{ route('report.summary') }}"
                                        class="subMenu {{ $request->routeIs('report.summary') ? 'active' : '' }}">
                                        {{ __('summary') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['coupons.index', 'currency.index', 'tax.index', 'profile.index', 'settings.general',
                    'payment-gateway'])
                    <li>
                        <a class="menu {{ $request->routeIs('coupons.*', 'currency.*', 'tax.*', 'profile.*', 'settings.*', 'payment-gateway.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#SettingMenu">
                            <span>
                                <img src="/icons/Setting.svg" class="menu-icon" alt="icon" />
                                {{ __('settings') }}
                            </span>
                            <img src="/icons/arrowDown.svg" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('coupons.*', 'currency.*', 'tax.*', 'profile.*', 'settings.*', 'payment-gateway.*') ? 'show' : '' }}"
                            id="SettingMenu">
                            <div class="listBar">

                                @can('coupons.index')
                                    <a href="{{ route('coupons.index') }}"
                                        class="subMenu {{ $request->routeIs('coupons.index') ? 'active' : '' }}">{{ __('coupons') }}</a>
                                @endcan
                                @can('currency.index')
                                    <a href="{{ route('currency.index') }}"
                                        class="subMenu {{ $request->routeIs('currency.index') ? 'active' : '' }}">{{ __('currencies') }}</a>
                                @endcan
                                @can('tax.index')
                                    <a href="{{ route('tax.index') }}"
                                        class="subMenu {{ $request->routeIs('tax.index') ? 'active' : '' }}">{{ __('taxs') }}</a>
                                @endcan
                                @can('profile.index')
                                    <a href="{{ route('profile.index', auth()->id()) }}"
                                        class="subMenu {{ $request->routeIs('profile.index') ? 'active' : '' }}">{{ __('profile') }}</a>
                                @endcan
                                @can('payment-gateway.index')
                                    <a href="{{ route('payment-gateway.index') }}"
                                        class="subMenu {{ $request->routeIs('payment-gateway.index') ? 'active' : '' }}">{{ __('payment_gateway') }}</a>
                                @endcan
                                @can('settings.mail')
                                    <a href="{{ route('settings.mail') }}"
                                        class="subMenu {{ $request->routeIs('settings.mail') ? 'active' : '' }}">{{ __('smtp_configure') }}</a>
                                @endcan
                                @can('settings.general')
                                    <a href="{{ route('settings.general') }}"
                                        class="subMenu {{ $request->routeIs('settings.general') ? 'active' : '' }}">{{ __('general_settings') }}</a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @can('language.index')
                    <li>
                        <a class="menu {{ $request->routeIs('language.*') ? 'active' : '' }}"
                            href="{{ route('language.index') }}">
                            <span>
                                <img src="/icons/language.svg" class="menu-icon" alt="icon" />
                                {{ __('language') }}
                            </span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
        <div class="sideBarfooter">
            <button type="button" class="fullbtn hite-icon" onclick="toggleFullScreen(document.body)"><i
                    class="fa-solid fa-expand"></i></button>
            <a href="{{ route('settings.general') }}" class="fullbtn hite-icon"><i class="fa-solid fa-cog"></i></a>
            <a href="{{ route('profile.index', auth()->id()) }}" class="fullbtn hite-icon"><i
                    class="fa-solid fa-user"></i></a>
            <a onclick="signout()" class="fullbtn hite-icon"><i class="fa-solid fa-power-off"></i></a>
        </div>
    </div>
</div>
