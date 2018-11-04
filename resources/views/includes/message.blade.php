@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <script>// 'rounded' is the class I'm applying to the toast
            document.addEventListener('DOMContentLoaded', function() {
                M.toast({html: '{{$error}}', classes: 'rounded'})
            });
        </script>
    @endforeach
@endif

@if(session('succes'))
    <script>// 'rounded' is the class I'm applying to the toast
        M.toast({html: 'succes!', classes: 'rounded'})
    </script>
@endif
@if(session('error'))
    <script>// 'rounded' is the class I'm applying to the toast
        M.toast({html: 'error!', classes: 'rounded'})
    </script>
@endif
