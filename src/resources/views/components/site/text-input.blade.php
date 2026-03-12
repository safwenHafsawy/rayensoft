@props(['disabled' => false, 'textSize' => 'text-md', 'icon' => null])


<div class="relative group">
    <input @disabled($disabled)
        {{ $attributes->merge([
            'class' => "w-full pl-11 py-3 bg-gray-50 border-gray-100 rounded-xl focus:bg-white focus:border-primaryColor focus:ring-4 focus:ring-primaryColor/10 transition-all font-body text-darkColor placeholder:text-gray-400",
        ]) }} />

    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
        <i class="fa-solid {{ $icon }} text-gray-400 group-focus-within:text-primaryColor transition-colors"></i>
    </div>
</div>
