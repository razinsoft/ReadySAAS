@extends('layout.app')
@section('title', __('permissions'))
@section('content')
    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between card-header-color">
                            <span class="list-title text-white">{{ __('permissions') }}</span>
                            <a href="{{ route('role.index') }}" class="btn btn-info2"><i class="fa fa-chevron-left "></i>
                                {{ __('back') }}</a>
                        </div>
                        <form action="{{ route('role.setPermission') }}" method="POST">
                            @csrf
                            <input type="hidden" value="1" name="permission[root]">
                            <input type="hidden" value="1" name="permission[signout]">
                            <div class="card-body">
                                <input type="hidden" name="role_id" value="{{ $role->id }}" />
                                <div class="table-responsive">
                                    <table class="table table-bordered permission-table table-hover">
                                        <thead>
                                            <tr>
                                                <th colspan="6" class="text-center">
                                                    {{ ucfirst($role->name) }} {{ __('permissions') }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2" class="text-center">{{ __('permission_name') }}</th>
                                                <th colspan="5" class="text-center">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="select_all">
                                                        <label for="select_all">{{ __('permissions') }}</label>
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">{{ __('view') }}</th>
                                                <th class="text-center">{{ __('add') }}</th>
                                                <th class="text-center">{{ __('edit') }}</th>
                                                <th class="text-center">{{ __('delete') }}</th>
                                                <th class="text-center">{{ __('extra') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ __('product') }}</td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue checked" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" id="products-index"
                                                                name="permission[product.index]"
                                                                {{ in_array('product.index', $permissions) ? 'checked' : '' }} />
                                                            <label for="products-index"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" id="products-add"
                                                                name="permission[product.create]"
                                                                {{ in_array('product.create', $permissions) ? 'checked' : '' }} />
                                                            <label for="products-add"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="products-edit"
                                                                name="permission[product.edit]"
                                                                {{ in_array('product.edit', $permissions) ? 'checked' : '' }} />
                                                            <label for="products-edit"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="products-delete"
                                                                name="permission[product.destroy]"
                                                                {{ in_array('product.destroy', $permissions) ? 'checked' : '' }} />
                                                            <label for="products-delete"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>
                                                        <div aria-checked="false" aria-disabled="false">
                                                            <div class="checkbox">
                                                                <input type="checkbox" value="1" id="print-barcode"
                                                                    name="permission[barcode.print]"
                                                                    {{ in_array('barcode.print', $permissions) ? 'checked' : '' }} />
                                                                <label for="print-barcode"
                                                                    class="padding05">{{ __('print_barcode') }}
                                                                    &nbsp;&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>{{ __('purchase') }}</td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="purchases-index"
                                                                name="permission[purchase.index]"
                                                                {{ in_array('purchase.index', $permissions) ? 'checked' : '' }} />
                                                            <label for="purchases-index"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="purchases-add"
                                                                name="permission[purchase.create]"
                                                                {{ in_array('purchase.create', $permissions) ? 'checked' : '' }} />
                                                            <label for="purchases-add"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="purchases-edit"
                                                                name="permission[purchase.edit]"
                                                                {{ in_array('purchase.edit', $permissions) ? 'checked' : '' }} />
                                                            <label for="purchases-edit"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="products-delete"
                                                                name="permission[purchase.destroy]"
                                                                {{ in_array('purchase.destroy', $permissions) ? 'checked' : '' }} />
                                                            <label for="purchases-delete"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="d-flex">
                                                    <span>
                                                        <div aria-checked="false" aria-disabled="false">
                                                            <div class="checkbox">
                                                                <input type="checkbox" value="1" id="stock-count"
                                                                    name="permission[stockCount.index]"
                                                                    {{ in_array('stockCount.index', $permissions) ? 'checked' : '' }} />
                                                                <label for="stock-count"
                                                                    class="padding05">{{ __('stock_count') }}
                                                                    &nbsp;&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </span>
                                                    <span>
                                                        <div aria-checked="false" aria-disabled="false">
                                                            <div class="checkbox">
                                                                <input type="checkbox" value="1" id="stock-add"
                                                                    name="permission[stockCount.store]"
                                                                    {{ in_array('stockCount.store', $permissions) ? 'checked' : '' }} />
                                                                <label for="stock-add"
                                                                    class="padding05">{{ __('stock_sdd') }}
                                                                    &nbsp;&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>{{ __('user') }}</td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue checked" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="users-index"
                                                                name="permission[user.index]"
                                                                {{ in_array('user.index', $permissions) ? 'checked' : '' }} />
                                                            <label for="users-index"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue checked" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="users-add"
                                                                name="permission[user.create]"
                                                                {{ in_array('user.create', $permissions) ? 'checked' : '' }} />
                                                            <label for="users-add"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue checked" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="users-edit"
                                                                name="permission[user.edit]"
                                                                {{ in_array('user.edit', $permissions) ? 'checked' : '' }} />
                                                            <label for="users-edit"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="users-delete"
                                                                name="permission[user.delete]"
                                                                {{ in_array('user.delete', $permissions) ? 'checked' : '' }} />
                                                            <label for="users-delete"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td>{{ __('customer') }}</td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue checked" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="customers-index"
                                                                name="permission[customer.index]"
                                                                {{ in_array('customer.index', $permissions) ? 'checked' : '' }} />
                                                            <label for="customers-index"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue checked" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="customers-add"
                                                                name="permission[customer.create]"
                                                                {{ in_array('customer.create', $permissions) ? 'checked' : '' }} />
                                                            <label for="customers-add"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue checked" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="customers-edit"
                                                                name="permission[customer.edit]"
                                                                {{ in_array('customer.edit', $permissions) ? 'checked' : '' }} />
                                                            <label for="customers-edit"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="customers-delete"
                                                                name="permission[customer.destroy]"
                                                                {{ in_array('customer.destroy', $permissions) ? 'checked' : '' }} />
                                                            <label for="customers-delete"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td>{{ __('supplier') }}</td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="suppliers-index"
                                                                name="permission[supplier.index]"
                                                                {{ in_array('supplier.index', $permissions) ? 'checked' : '' }} />
                                                            <label for="suppliers-index"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="suppliers-add"
                                                                name="permission[supplier.create]"
                                                                {{ in_array('supplier.create', $permissions) ? 'checked' : '' }} />
                                                            <label for="suppliers-add"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="suppliers-edit"
                                                                name="permission[supplier.edit]"
                                                                {{ in_array('supplier.edit', $permissions) ? 'checked' : '' }} />
                                                            <label for="suppliers-edit"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="suppliers-delete"
                                                                name="permission[supplier.destroy]"
                                                                {{ in_array('supplier.destroy', $permissions) ? 'checked' : '' }} />
                                                            <label for="suppliers-delete"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td>{{ __('category') }}</td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="category-index"
                                                                name="permission[category.index]"
                                                                {{ in_array('category.index', $permissions) ? 'checked' : '' }} />
                                                            <label for="category-index"></label>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="category.store"
                                                                name="permission[category.store]"
                                                                {{ in_array('category.store', $permissions) ? 'checked' : '' }} />
                                                            <label for="category.store"></label>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="category.update"
                                                                name="permission[category.update]"
                                                                {{ in_array('category.update', $permissions) ? 'checked' : '' }} />
                                                            <label for="category.update"></label>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="category.delete"
                                                                name="permission[category.delete]"
                                                                {{ in_array('category.delete', $permissions) ? 'checked' : '' }} />
                                                            <label for="category.delete"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('accounting') }}</td>
                                                <td class="text-center">
                                                    <div class="icheckbox_square-blue" aria-checked="false"
                                                        aria-disabled="false">
                                                        <div class="checkbox">
                                                            <input type="checkbox" value="1" id="account.index"
                                                                name="permission[account.index]"
                                                                {{ in_array('account.index', $permissions) ? 'checked' : '' }} />
                                                            <label for="account.index"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="report-permissions" colspan="5">
                                                    <span>
                                                        <div aria-checked="false" aria-disabled="false">
                                                            <div class="checkbox">
                                                                <input type="checkbox" value="1" id="money-transfer"
                                                                    name="permission[moneyTransfer.index]"
                                                                    {{ in_array('moneyTransfer.index', $permissions) ? 'checked' : '' }} />
                                                                <label for="money-transfer"
                                                                    class="padding05">{{ __('money_transfer') }}
                                                                    &nbsp;&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </span>
                                                    <span>
                                                        <div aria-checked="false" aria-disabled="false">
                                                            <div class="checkbox">
                                                                <input type="checkbox" value="1" id="balance-sheet"
                                                                    name="permission[account.balancesheet]"
                                                                    {{ in_array('account.balancesheet', $permissions) ? 'checked' : '' }} />
                                                                <label for="balance-sheet"
                                                                    class="padding05">{{ __('balance_sheet') }}
                                                                    &nbsp;&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </span>
                                                    <span>
                                                        <div aria-checked="false" aria-disabled="false">
                                                            <div class="checkbox">
                                                                <input type="checkbox" value="1" id="transection"
                                                                    name="permission[transection.index]"
                                                                    {{ in_array('transection.index', $permissions) ? 'checked' : '' }} />
                                                                <label for="transection"
                                                                    class="padding05">{{ __('transection') }}
                                                                    &nbsp;&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('settings') }}</td>
                                                <td class="report-permissions" colspan="5">

                                                    <span>
                                                        <div aria-checked="false" aria-disabled="false">
                                                            <div class="checkbox">
                                                                <input type="checkbox" value="1" id="warehouse"
                                                                    name="permission[warehouse.index]"
                                                                    {{ in_array('warehouse.index', $permissions) ? 'checked' : '' }} />
                                                                <label for="warehouse"
                                                                    class="padding05">{{ __('warehouse') }}
                                                                    &nbsp;&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </span>
                                                    <span>
                                                        <div aria-checked="false" aria-disabled="false">
                                                            <div class="checkbox">
                                                                <input type="checkbox" value="1" id="customer_group"
                                                                    name="permission[customer_group.index]"
                                                                    {{ in_array('customer_group.index', $permissions) ? 'checked' : '' }} />
                                                                <label for="customer_group"
                                                                    class="padding05">{{ __('customer_group') }}
                                                                    &nbsp;&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </span>
                                                    <span>
                                                        <div aria-checked="false" aria-disabled="false">
                                                            <div class="checkbox">
                                                                <input type="checkbox" value="1" id="brand"
                                                                    name="permission[brand.index]"
                                                                    {{ in_array('brand.index', $permissions) ? 'checked' : '' }} />
                                                                <label for="brand"
                                                                    class="padding05">{{ __('brand') }}
                                                                    &nbsp;&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </span>
                                                    <span>
                                                        <div aria-checked="false" aria-disabled="false">
                                                            <div class="checkbox">
                                                                <input type="checkbox" value="1" id="brand"
                                                                    name="permission[coupons.index]"
                                                                    {{ in_array('coupons.index', $permissions) ? 'checked' : '' }} />
                                                                <label for="brand"
                                                                    class="padding05">{{ __('coupon') }}
                                                                    &nbsp;&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </span>
                                                    <span>
                                                        <div aria-checked="false" aria-disabled="false">
                                                            <div class="checkbox">
                                                                <input type="checkbox" value="1" id="unit"
                                                                    name="permission[unit.index]"
                                                                    {{ in_array('unit.index', $permissions) ? 'checked' : '' }} />
                                                                <label for="unit"
                                                                    class="padding05">{{ __('unit') }}
                                                                    &nbsp;&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </span>
                                                    <span>
                                                        <div aria-checked="false" aria-disabled="false">
                                                            <div class="checkbox">
                                                                <input type="checkbox" value="1" id="currency"
                                                                    name="permission[currency.index]"
                                                                    {{ in_array('currency.index', $permissions) ? 'checked' : '' }} />
                                                                <label for="currency"
                                                                    class="padding05">{{ __('currency') }}
                                                                    &nbsp;&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </span>
                                                    <span>
                                                        <div aria-checked="false" aria-disabled="false">
                                                            <div class="checkbox">
                                                                <input type="checkbox" value="1" id="tax"
                                                                    name="permission[tax.index]"
                                                                    {{ in_array('tax.index', $permissions) ? 'checked' : '' }} />
                                                                <label for="tax"
                                                                    class="padding05">{{ __('tax') }}
                                                                    &nbsp;&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </span>
                                                    <span>
                                                        <div aria-checked="false" aria-disabled="false">
                                                            <div class="checkbox">
                                                                <input type="checkbox" value="1"
                                                                    id="general_setting"
                                                                    name="permission[settings.general]"
                                                                    {{ in_array('settings.general', $permissions) ? 'checked' : '' }} />
                                                                <label for="general_setting"
                                                                    class="padding05">{{ __('general_settings') }}
                                                                    &nbsp;&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </span>
                                                    <span>
                                                        <div aria-checked="false" aria-disabled="false">
                                                            <div class="checkbox">
                                                                <input type="checkbox" value="1" id="profile_index"
                                                                    name="permission[profile.index]"
                                                                    {{ in_array('profile.index', $permissions) ? 'checked' : '' }} />
                                                                <label for="profile_index"
                                                                    class="padding05">{{ __('profile') }}
                                                                    &nbsp;&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn common-btn">{{ __('update_and_Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @if ($errors->all())
        <script>
            Toast.fire({
                icon: 'error',
                title: "At least select one permission"
            })
        </script>
    @endif
    <script>
        $('#select_all').on('click', function() {
            if ($(this).is(':not(:checked)')) {
                $('input[type="checkbox"]').attr('checked', false);
            } else {
                $('input[type="checkbox"]').attr('checked', true);
            }
        });
    </script>
@endpush
