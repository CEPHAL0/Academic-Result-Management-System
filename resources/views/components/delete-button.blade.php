<button type="submit"
    {{ $attributes->merge(['class' => 'text-custom-black bg-white py-[5px] px-4 font-normal text-base text-center rounded-md hover:bg-dark-orange hover:text-white border border-black hover:border-dark-orange transition-colors']) }}>
    {{ $slot }}
</button>
