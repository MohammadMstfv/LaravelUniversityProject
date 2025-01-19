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
    <!-- Toggle Buttons -->
    <div class="flex justify-between space-x-4">
        <button id="toggleButton" 
            class="text-center text-lg font-medium text-gray-800 bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded-lg shadow-sm">
            اعلام نمرات شما
        </button>
        <button id="foodReserveButton" 
            class="text-center text-lg font-medium text-gray-800 bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded-lg shadow-sm">
            رزرو غذا
        </button>
    </div>

    <!-- Grades Section -->
    <div id="courseSection" class="hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
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
                    onclick="eterazOpen('{{ $course }}')">ثبت اعتراض</button>
            </div>
        @endforeach
    </div>

    <!-- Food Reservation Section -->
    <div id="foodReserveSection" class="hidden space-y-6 mt-6 text-center">
        <!-- Week Buttons -->
        <div class="flex justify-center space-x-4">
            <button id="prevWeekButton" class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded-lg">هفته قبل</button>
            <button id="currentWeekButton" class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded-lg">این هفته</button>
            <button id="nextWeekButton" class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded-lg">هفته بعد</button>
        </div>

        <!-- Food Table -->
        <div class="flex justify-center">
            <table id="foodTable" class="border border-gray-300 mt-4 text-center">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b text-gray-700">روز</th>
                        <th class="px-4 py-2 border-b text-gray-700">غذا</th>
                        <th class="px-4 py-2 border-b text-gray-700">انتخاب</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rows will be dynamically updated -->
                </tbody>
            </table>
        </div>

        <!-- Bottom Buttons -->
        <div class="flex justify-center space-x-4 mt-4">
            <button class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg">لغو</button>
            <button class="bg-green-500 hover:bg-green-600 text-grey-900 py-2 px-4 rounded-lg">ثبت</button>
        </div>
    </div>
</div>

<!-- Objection Modal -->
<div id="EterazPopup" class="fixed z-10 inset-0 hidden flex justify-center items-center">
    <div class="fixed inset-0 bg-black opacity-50"></div>
    <div class="bg-white rounded-lg shadow-lg transform transition-all sm:max-w-md w-full p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4" id="EterazTitr">ثبت اعتراض</h3>
        <textarea id="EterazMatn" rows="4" class="form-input border-gray-300 rounded-lg block w-full p-2"
            placeholder="اعتراض خود را وارد کنید..."></textarea>
        <div class="mt-4 flex justify-end space-x-2">
            <button onclick="eterazSubmit()"
                class="bg-green-500 hover:bg-green-600 text-gray-800 py-2 px-4 rounded-lg text-sm">ثبت</button>
            <button onclick="eterazClose()"
                class="bg-gray-300 hover:bg-gray-400 text-gray-500 py-2 px-4 rounded-lg text-sm">لغو</button>
        </div>
    </div>
</div>

<script>
    // Toggle visibility for grades section
    const toggleButton = document.getElementById("toggleButton");
    const courseSection = document.getElementById("courseSection");

    toggleButton.addEventListener("click", () => {
        courseSection.classList.toggle("hidden");
    });

    // Toggle visibility for food reservation section
    const foodReserveButton = document.getElementById("foodReserveButton");
    const foodReserveSection = document.getElementById("foodReserveSection");

    foodReserveButton.addEventListener("click", () => {
        foodReserveSection.classList.toggle("hidden");
    });

    // Food data for different weeks
    const weekFoods = {
        prevWeek: ['قیمه', 'خورشت کرفس', 'کشک بادمجان', 'ته‌چین', 'سبزی‌پلو', 'خوراک مرغ', 'پیتزا'],
        currentWeek: ['قورمه‌سبزی', 'کباب', 'ماکارونی', 'زرشک‌پلو', 'آبگوشت', 'کتلت', 'عدس‌پلو'],
        nextWeek: ['خوراک لوبیا', 'کوکو سبزی', 'لازانیا', 'مرغ سوخاری', 'پلو مخلوط', 'ماهی', 'قیمه'],
    };

    // Days of the week
    const days = ['شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'];

    // Populate food table
    const foodTableBody = document.querySelector("#foodTable tbody");
    function populateTable(weekKey) {
        foodTableBody.innerHTML = ""; // Clear existing rows
        weekFoods[weekKey].forEach((food, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td class="px-4 py-2 border-b text-gray-800 text-right">${days[index]}</td>
                <td class="px-4 py-2 border-b text-gray-800 text-right">${food}</td>
                <td class="px-4 py-2 border-b text-center">
                    <input type="checkbox" class="form-checkbox text-blue-500">
                </td>
            `;
            foodTableBody.appendChild(row);
        });
    }

    // Event listeners for week buttons
    document.getElementById("prevWeekButton").addEventListener("click", () => populateTable("prevWeek"));
    document.getElementById("currentWeekButton").addEventListener("click", () => populateTable("currentWeek"));
    document.getElementById("nextWeekButton").addEventListener("click", () => populateTable("nextWeek"));

    // Initialize table with current week's data
    populateTable("currentWeek");

    // Objection modal functionality
    function eterazOpen(course) {
        document.getElementById("EterazPopup").classList.remove("hidden");
        document.getElementById("EterazTitr").innerText = `ثبت اعتراض برای ${course}`;
    }

    function eterazClose() {
        document.getElementById("EterazPopup").classList.add("hidden");
    }

    function eterazSubmit() {
        const objectionText = document.getElementById("EterazMatn").value.trim();
        if (objectionText === "") {
            alert("لطفاً متن اعتراض را وارد کنید.");
            return;
        }

        eterazClose();
        alert("اعتراض شما با موفقیت ثبت شد");
    }
</script>




</x-app-layout>
