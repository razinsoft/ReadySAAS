@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ __('installer_messages.environment.wizard.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-magic fa-fw" aria-hidden="true"></i>
    {!! __('installer_messages.environment.wizard.title') !!}
@endsection

@section('container')
    <div class="tabs tabs-full">

        <input id="tab1" type="radio" name="tabs" class="tab-input" checked />
        <label for="tab1" class="tab-label">
            <i class="fa fa-cog fa-2x fa-fw" aria-hidden="true"></i>
            <br />
            {{ __('installer_messages.environment.wizard.tabs.environment') }}
        </label>

        <input id="tab2" type="radio" name="tabs" class="tab-input" />
        <label for="tab2" class="tab-label">
            <i class="fa fa-database fa-2x fa-fw" aria-hidden="true"></i>
            <br />
            {{ __('installer_messages.environment.wizard.tabs.database') }}
        </label>

        {{-- <input id="tab3" type="radio" name="tabs" class="tab-input" />
        <label for="tab3" class="tab-label">
            <i class="fa fa-cogs fa-2x fa-fw" aria-hidden="true"></i>
            <br />
            {{ __('installer_messages.environment.wizard.tabs.application') }}
        </label> --}}

        <form method="post" action="{{ route('LaravelInstaller::environmentSaveWizard') }}" class="tabs-wrap">
            <div class="tab" id="tab1content">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group {{ $errors->has('app_name') ? ' has-error ' : '' }}">
                    <label for="app_name">
                        {{ __('installer_messages.environment.wizard.form.app_name_label') }}
                    </label>
                    <input type="text" name="app_name" id="app_name" value="" placeholder="{{ __('installer_messages.environment.wizard.form.app_name_placeholder') }}" />
                    @if ($errors->has('app_name'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_name') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('environment') ? ' has-error ' : '' }}">
                    <label for="environment">
                        {{ __('installer_messages.environment.wizard.form.app_environment_label') }}
                    </label>
                    <select name="environment" id="environment" onchange='checkEnvironment(this.value);'>
                        <option value="production">{{ __('installer_messages.environment.wizard.form.app_environment_label_production') }}</option>
                    </select>
                    <div id="environment_text_input" style="display: none;">
                        <input type="text" name="environment_custom" id="environment_custom" placeholder="{{ __('installer_messages.environment.wizard.form.app_environment_placeholder_other') }}"/>
                    </div>
                    @if ($errors->has('app_name'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_name') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('app_debug') ? ' has-error ' : '' }}">
                    <label for="app_debug">
                        {{ __('installer_messages.environment.wizard.form.app_debug_label') }}
                    </label>
                    <label for="app_debug_true">
                        <input type="radio" name="app_debug" id="app_debug_true" value=true checked />
                        {{ __('installer_messages.environment.wizard.form.app_debug_label_true') }}
                    </label>
                    <label for="app_debug_false">
                        <input type="radio" name="app_debug" id="app_debug_false" value=false />
                        {{ __('installer_messages.environment.wizard.form.app_debug_label_false') }}
                    </label>
                    @if ($errors->has('app_debug'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_debug') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('filesystem_disk') ? ' has-error ' : '' }}">
                    <label for="filesystem_disk">
                        {{ __('installer_messages.environment.wizard.form.app_file_system_disk') }}
                    </label>
                    <select name="filesystem_disk" id="filesystem_disk">
                        <option value="public" selected>{{ __('installer_messages.environment.wizard.form.app_file_system_disk_public') }}</option>
                        <option value="local">{{ __('installer_messages.environment.wizard.form.app_file_system_disk_local') }}</option>
                    </select>
                    @if ($errors->has('filesystem_disk'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('filesystem_disk') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('app_url') ? ' has-error ' : '' }}">
                    <label for="app_url">
                        {{ __('installer_messages.environment.wizard.form.app_url_label') }}
                    </label>
                    <input type="url" name="app_url" id="app_url" value="http://localhost" placeholder="{{ __('installer_messages.environment.wizard.form.app_url_placeholder') }}" />
                    @if ($errors->has('app_url'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_url') }}
                        </span>
                    @endif
                </div>

                <div class="buttons">
                    <button class="button" onclick="showDatabaseSettings();return false">
                        {{ __('installer_messages.environment.wizard.form.buttons.setup_database') }}
                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="tab" id="tab2content">

                <div class="form-group {{ $errors->has('database_connection') ? ' has-error ' : '' }}">
                    <label for="database_connection">
                        {{ __('installer_messages.environment.wizard.form.db_connection_label') }}
                    </label>
                    <select name="database_connection" id="database_connection">
                        <option value="mysql" selected>{{ __('installer_messages.environment.wizard.form.db_connection_label_mysql') }}</option>
                        <option value="sqlite">{{ __('installer_messages.environment.wizard.form.db_connection_label_sqlite') }}</option>
                        <option value="pgsql">{{ __('installer_messages.environment.wizard.form.db_connection_label_pgsql') }}</option>
                        <option value="sqlsrv">{{ __('installer_messages.environment.wizard.form.db_connection_label_sqlsrv') }}</option>
                    </select>
                    @if ($errors->has('database_connection'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_connection') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_hostname') ? ' has-error ' : '' }}">
                    <label for="database_hostname">
                        {{ __('installer_messages.environment.wizard.form.db_host_label') }}
                    </label>
                    <input type="text" name="database_hostname" id="database_hostname" value="127.0.0.1" placeholder="{{ __('installer_messages.environment.wizard.form.db_host_placeholder') }}" />
                    @if ($errors->has('database_hostname'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_hostname') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_port') ? ' has-error ' : '' }}">
                    <label for="database_port">
                        {{ __('installer_messages.environment.wizard.form.db_port_label') }}
                    </label>
                    <input type="number" name="database_port" id="database_port" value="3306" placeholder="{{ __('installer_messages.environment.wizard.form.db_port_placeholder') }}" />
                    @if ($errors->has('database_port'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_port') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_name') ? ' has-error ' : '' }}">
                    <label for="database_name">
                        {{ __('installer_messages.environment.wizard.form.db_name_label') }}
                    </label>
                    <input type="text" name="database_name" id="database_name" value="" placeholder="{{ __('installer_messages.environment.wizard.form.db_name_placeholder') }}" />
                    @if ($errors->has('database_name'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_name') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_username') ? ' has-error ' : '' }}">
                    <label for="database_username">
                        {{ __('installer_messages.environment.wizard.form.db_username_label') }}
                    </label>
                    <input type="text" name="database_username" id="database_username" value="" placeholder="{{ __('installer_messages.environment.wizard.form.db_username_placeholder') }}" />
                    @if ($errors->has('database_username'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_username') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_password') ? ' has-error ' : '' }}">
                    <label for="database_password">
                        {{ __('installer_messages.environment.wizard.form.db_password_label') }}
                    </label>
                    <input type="password" name="database_password" id="database_password" value="" placeholder="{{ __('installer_messages.environment.wizard.form.db_password_placeholder') }}" />
                    @if ($errors->has('database_password'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_password') }}
                        </span>
                    @endif
                </div>

                <div class="buttons">
                    <button class="button" type="submit">
                        {{ __('installer_messages.environment.wizard.form.buttons.install') }}
                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            {{-- <div class="tab" id="tab3content">

                <div class="form-group {{ $errors->has('mail_driver') ? ' has-error ' : '' }}">
                    <label for="mail_driver">
                        {{ __('installer_messages.environment.wizard.form.app_tabs.mail_driver_label') }}
                        <sup>
                            <a href="https://laravel.com/docs/5.4/mail" target="_blank" title="{{ __('installer_messages.environment.wizard.form.app_tabs.more_info') }}">
                                <i class="fa fa-info-circle fa-fw" aria-hidden="true"></i>
                                <span class="sr-only">{{ __('installer_messages.environment.wizard.form.app_tabs.more_info') }}</span>
                            </a>
                        </sup>
                    </label>
                    <input type="text" name="mail_driver" id="mail_driver" value="smtp" placeholder="{{ __('installer_messages.environment.wizard.form.app_tabs.mail_driver_placeholder') }}" />
                    @if ($errors->has('mail_driver'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('mail_driver') }}
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('mail_host') ? ' has-error ' : '' }}">
                    <label for="mail_host">{{ __('installer_messages.environment.wizard.form.app_tabs.mail_host_label') }}</label>
                    <input type="text" name="mail_host" id="mail_host" value="smtp.mailtrap.io" placeholder="{{ __('installer_messages.environment.wizard.form.app_tabs.mail_host_placeholder') }}" />
                    @if ($errors->has('mail_host'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('mail_host') }}
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('mail_port') ? ' has-error ' : '' }}">
                    <label for="mail_port">{{ __('installer_messages.environment.wizard.form.app_tabs.mail_port_label') }}</label>
                    <input type="number" name="mail_port" id="mail_port" value="2525" placeholder="{{ __('installer_messages.environment.wizard.form.app_tabs.mail_port_placeholder') }}" />
                    @if ($errors->has('mail_port'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('mail_port') }}
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('mail_username') ? ' has-error ' : '' }}">
                    <label for="mail_username">{{ __('installer_messages.environment.wizard.form.app_tabs.mail_username_label') }}</label>
                    <input type="text" name="mail_username" id="mail_username" value="null" placeholder="{{ __('installer_messages.environment.wizard.form.app_tabs.mail_username_placeholder') }}" />
                    @if ($errors->has('mail_username'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('mail_username') }}
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('mail_password') ? ' has-error ' : '' }}">
                    <label for="mail_password">{{ __('installer_messages.environment.wizard.form.app_tabs.mail_password_label') }}</label>
                    <input type="text" name="mail_password" id="mail_password" value="null" placeholder="{{ __('installer_messages.environment.wizard.form.app_tabs.mail_password_placeholder') }}" />
                    @if ($errors->has('mail_password'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('mail_password') }}
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('mail_encryption') ? ' has-error ' : '' }}">
                    <label for="mail_encryption">{{ __('installer_messages.environment.wizard.form.app_tabs.mail_encryption_label') }}</label>
                    <input type="text" name="mail_encryption" id="mail_encryption" value="null" placeholder="{{ __('installer_messages.environment.wizard.form.app_tabs.mail_encryption_placeholder') }}" />
                    @if ($errors->has('mail_encryption'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('mail_encryption') }}
                        </span>
                    @endif
                </div>

                <div class="buttons">
                    <button class="button" type="submit">
                        {{ __('installer_messages.environment.wizard.form.buttons.install') }}
                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
            </div> --}}
        </form>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function checkEnvironment(val) {
            var element=document.getElementById('environment_text_input');
            if(val=='other') {
                element.style.display='block';
            } else {
                element.style.display='none';
            }
        }
        function showDatabaseSettings() {
            document.getElementById('tab2').checked = true;
        }
        function showApplicationSettings() {
            document.getElementById('tab3').checked = true;
        }
    </script>
@endsection
