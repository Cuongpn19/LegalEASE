<form action="{{ route('client.storequestion') }}" method="POST">
    @csrf
    <input type="hidden" name="lawyer_id" value="{{ $lawyer->user_id }}">
    <textarea name="question" placeholder="Nhập câu hỏi của bạn tại đây..." required></textarea>
    <button type="submit">Gửi câu hỏi</button>
</form>