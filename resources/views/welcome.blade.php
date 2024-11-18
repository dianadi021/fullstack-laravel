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
        // ONLOAD START
        $(document).ready(function() {
            $("#loginSection").hide();
        })
        // ONLOAD END

        // FUNCTION ON CHECK START
        // FUNCTION ON CHECK END

        // FUNCTIONS START
        function submitForm($section) {
            event.preventDefault();
            $(".hide_notif").hide();

            if ($section == "registerForm") {
                if (!$("#klinik_name").val()) {
                    AllNotify("Nama Klinik tidak boleh kosong!", "error");
                    $("#klinik_name").focus();
                    return false;
                }

                if (!$("#provinsi").val()) {
                    AllNotify("Provinsi tidak boleh kosong!", "error");
                    $("#provinsi").focus();
                    return false;
                }

                if (!$("#kabupaten").val()) {
                    AllNotify("Kabupaten tidak boleh kosong!", "error");
                    $("#kabupaten").focus();
                    return false;
                }

                if (!$("#kecamatan").val()) {
                    AllNotify("Kecamatan tidak boleh kosong!", "error");
                    $("#kecamatan").focus();
                    return false;
                }

                if (!$("#kelurahan").val()) {
                    AllNotify("Kelurahan tidak boleh kosong!", "error");
                    $("#kelurahan").focus();
                    return false;
                }
            }

            Swal.fire({
                title: "Apakah yakin ingin melanjutkan?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Batal",
                confirmButtonText: "Lanjutkan"
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#clientRegist").show();
                    $(".csrf-token").val($('meta[name="csrf-token"]').attr('content'));

                    $(".hideBtnProcess").hide();
                    LoadingNotify("Sedang diproses, mohon tunggu!", "info", true);

                    if ($section == "registerForm") {
                        $.ajax({
                            url: `${$base_url}/api/v1/users`,
                            type: "POST",
                            data: $("#registerForm").serializeArray(),
                            xhrFields: {
                                withCredentials: true
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(callback) {
                                const { messages, message } = callback;
                                console.dir(callback);
                                AllNotify(messages || message, "success");

                                setTimeout(() => {
                                    LoginAjaxSection($("#registerForm").serializeArray());
                                }, 1500);
                            },
                            error: function(callback) {
                                const { responseJSON } = callback;
                                const { errors, message, messages, data } = getVarValue(responseJSON);
                                let errorInfo, validator;
                                if (data) {
                                    const { errorInfo: errInfo, validator: validCallback } = data
                                    errorInfo = errInfo;
                                    validator = validCallback;
                                }
                                console.dir(callback);

                                if (errors) {
                                    for (let key in errors) {
                                        AllNotify(errors[key][0], "error");
                                        $(`#err_${key}`).show();
                                        $(`#err_${key} li`).html(errors[key][0]);
                                    }
                                } else if (message || messages || errorInfo || validator) {
                                    const $txtMsgAlert = (validator ? "input data tidak sesuai atau tidak boleh kosong" : ( errorInfo ? errorInfo[2] : (messages ? messages : message)));
                                    LoadingNotify($txtMsgAlert, "error");
                                }

                                LoadingNotify();
                                $(".hideBtnProcess").show();
                            },
                        });
                    }

                    if ($section == "loginForm") {
                        LoginAjaxSection($("#loginForm").serializeArray(), $('meta[name="csrf-token"]').attr('content'));
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
