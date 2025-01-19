<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-900 leading-tight">
            {{ __('داشبورد') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("وارد شدید !") }}
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 space-y-6">
    <h1 class="text-center text-2xl font-bold text-gray-800"> اعلام نمرات شما</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $courses = ['صدا در چند رسانه ای', 'کاربرد های وب', 'گرافیک متحرک', 'تجزیه تحلیل', 'هوش مصنوعی', 'تصویر برداری'];
            $grades = [20, 19, 20, 20, 20, 20];
        @endphp

        @foreach($courses as $index => $course)
            <div class="bg-gradient-to-r from-purple-200 via-purple-100 to-purple-200 p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $course }}</h2>
                <label class="text-gray-700 text-sm block mb-2">نمره:</label>
                <input type="text" value="{{ $grades[$index] }}" readonly
                    class="border-none bg-transparent font-bold text-gray-700 mb-4 w-full text-right focus:outline-none">
                <button class="bg-purple-500 hover:bg-purple-600 text-gray-400 py-2 px-4 rounded-full text-sm"
                    onclick="openObjectionModal('{{ $course }}')">ثبت اعتراض</button>
            </div>
        @endforeach
    </div>
</div>

<!-- پاپ‌آپ اعتراض -->
<div id="objectionModal" class="fixed z-10 inset-0 hidden flex justify-center items-center">
    <div class="fixed inset-0 bg-black opacity-50"></div>
    <div class="bg-white rounded-lg shadow-lg transform transition-all sm:max-w-md w-full p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4" id="modal-title">ثبت اعتراض</h3>
        <textarea id="objection_text" rows="4" class="form-input border-gray-300 rounded-lg block w-full p-2"
            placeholder="اعتراض خود را وارد کنید..."></textarea>
        <div class="mt-4 flex justify-end space-x-2">
            <button onclick="submitObjection()"
                class="bg-green-500 hover:bg-green-600 text-gray-800 py-2 px-4 rounded-lg text-sm">ثبت</button>
            <button onclick="closeObjectionModal()"
                class="bg-gray-300 hover:bg-gray-400 text-gray-500 py-2 px-4 rounded-lg text-sm">لغو</button>
        </div>
    </div>
</div>

<script>
    function openObjectionModal(course) {
        document.getElementById("objectionModal").classList.remove("hidden");
        document.getElementById("modal-title").innerText = `ثبت اعتراض برای ${course}`;
    }

    function closeObjectionModal() {
        document.getElementById("objectionModal").classList.add("hidden");
    }

    function submitObjection() {
        const objectionText = document.getElementById("objection_text").value.trim();
        if (objectionText === "") {
            alert("لطفاً متن اعتراض را وارد کنید.");
            return;
        }

        closeObjectionModal();
        alert("اعتراض شما با موفقیت ثبت شد");
    }
</script>

</x-app-layout>
