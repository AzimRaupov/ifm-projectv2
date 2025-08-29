@extends('layouts.teacher')

@section('head')
    <script src="https://cdn.tiny.cloud/1/yc1vna9wb6j6dcol17ksd2cfbwws4l2i4w40l3lzdyi4uxyj/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section('content-main')
    <form method="POST" action="{{route('teacher.vocabulary.update')}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{$vocabulary->id}}">
        <textarea name="content" class="tinymce">{{ $vocabulary->text }}</textarea>
        <button type="submit">Сохранить</button>
    </form>
@endsection

@section('script')
    <script>
        const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = true; // обязательно, если у тебя CSRF

            xhr.open('POST', '{{ route("teacher.vocabulary.img") }}');

            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

            xhr.upload.onprogress = (e) => {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = () => {
                if (xhr.status === 403) {
                    reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                }

                let json;
                try {
                    json = JSON.parse(xhr.responseText);
                } catch (err) {
                    reject('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                if (!json || typeof json.location !== 'string') {
                    reject('Invalid response format: ' + xhr.responseText);
                    return;
                }

                resolve(json.location);
            };

            xhr.onerror = () => {
                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        });

        tinymce.init({
            selector: 'textarea.tinymce',
            height: 400,
            plugins: 'lists link image preview code media',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image media | preview code',
            images_upload_handler: example_image_upload_handler,
            valid_elements: '*[*]',
            extended_valid_elements: '*[*]',
            language: 'ru',
        });
    </script>
@endsection
