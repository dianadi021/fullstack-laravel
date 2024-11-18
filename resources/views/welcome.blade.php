@extends('layouts.app')

@section('title', 'Fullstack Laravel')

@section('root_container')
    <main class="w-full flex items-center justify-center h-screen">
        <div id="registerSection">
            @include('layouts.partials.register')
        </div>
        <div id="loginSection">
            @include('layouts.partials.login')
        </div>
    </main>

    <script>
        const base_url = window.location.host;
        const [host, port] = base_url.split(':');
        const $base_url = (IsValidVal(port) ? `http://${host}:${port}` : `https://${host}`);

        // ONLOAD START
        $(document).ready(function() {
            $("#loginSection").hide();
            // $("#registerSection").hide();
        })
        // ONLOAD END

        // FUNCTIONS START
        function submitForm($section) {
            event.preventDefault();
            $(".hide_notif").each(function() {
                $(this).hide();
            });

            Swal.fire({
                title: "Apakah kamu yakin ingin melanjutkan?",
                // text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Batal",
                confirmButtonText: "Oke!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#_csrf-token").val($('meta[name="csrf-token"]').attr('content'));
                    $("#csrf-token").val($('meta[name="csrf-token"]').attr('content'));

                    $("#loadingAjax").show();
                    $(".hideBtnProcess").hide();
                    toastr.warning("Sedang diproses, mohon tunggu!", "Peringatan!");

                    let flagRegistSuccess = false;
                    if ($section == "registerForm") {
                        $.ajax({
                            url: `${$base_url}/api/users`,
                            type: "POST",
                            data: $("#registerForm").serializeArray(),
                            xhrFields: {
                                withCredentials: true
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(callback) {
                                const {
                                    messages
                                } = callback;
                                flagRegistSuccess = true;
                                console.dir('success', callback);
                                toastr.success(messages, "Success!");
                            },
                            error: function(callback) {
                                const {
                                    responseJSON
                                } = callback;
                                const {
                                    errors,
                                    message,
                                    messages,
                                    datas
                                } = responseJSON;
                                let errorInfo, validator;
                                if (datas) {
                                    const {
                                        errorInfo: errInfo,
                                        validator: validCallback
                                    } = datas
                                    errorInfo = errInfo;
                                    validator = validCallback;
                                }
                                console.dir('error', callback);

                                if (errors) {
                                    for (let key in errors) {
                                        toastr.error(errors[key][0], "Kesalahan!");
                                        $(`#err_${key}`).show();
                                        $(`#err_${key} li`).html(errors[key][0]);
                                    }
                                } else if (message || messages || errorInfo || validator) {
                                    const tmpMsg = (validator ?
                                        "input data tidak sesuai atau tidak boleh kosong" : (
                                            errorInfo ? errorInfo[2] : (messages ? messages :
                                                message)));
                                    toastr.error(tmpMsg, "Kesalahan!");
                                }

                                $("#loadingAjax").hide();
                                $(".hideBtnProcess").show();
                            },
                        });
                    }

                    const postFormData = ($section == "registerForm") ? $("#registerForm").serializeArray() : $(
                        "#loginForm").serializeArray();

                    if (flagRegistSuccess || $section == "loginForm") {
                        $.ajax({
                            url: `${$base_url}/login`,
                            type: "POST",
                            data: postFormData,
                            xhrFields: {
                                withCredentials: true
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(callback) {
                                console.dir('success', callback);
                                toastr.success('berhasil login!', "Success!");

                                setTimeout(() => {
                                    window.location.href = `${$base_url}/dashboard`;
                                }, 1500);
                            },
                            error: function(callback) {
                                const {
                                    responseJSON
                                } = callback;
                                const {
                                    errors,
                                    message,
                                    messages,
                                    datas
                                } = responseJSON;
                                let errorInfo, validator;
                                if (datas) {
                                    const {
                                        errorInfo: errInfo,
                                        validator: validCallback
                                    } = datas
                                    errorInfo = errInfo;
                                    validator = validCallback;
                                }
                                console.dir('error', callback);

                                if (errors) {
                                    for (let key in errors) {
                                        toastr.error(errors[key][0], "Kesalahan!");
                                        $(`#err_${key}`).show();
                                        $(`#err_${key} li`).html(errors[key][0]);
                                    }
                                } else if (message || messages || errorInfo || validator) {
                                    const tmpMsg = (validator ?
                                        "input data tidak sesuai atau tidak boleh kosong" : (
                                            errorInfo ? errorInfo[2] : (messages ? messages :
                                                message)));
                                    toastr.error(tmpMsg, "Kesalahan!");
                                }

                                $("#loadingAjax").hide();
                                $(".hideBtnProcess").show();

                                Swal.fire({
                                    title: "Kesalahan!",
                                    text: message || messages || errorInfo || validator,
                                    icon: "error"
                                }).then(function() {
                                    window.location.reload();
                                });
                            },
                        });
                    }
                }
            });
        }

        function openSection($section) {
            if ($section == "registerSection") {
                $("#loginSection").hide();
                $("#registerSection").show();
            }
            if ($section == "loginSection") {
                $("#registerSection").hide();
                $("#loginSection").show();
            }
        }
        // FUNCTIONS END
    </script>
@endsection
