<button type="submit"
    {{ $attributes->merge(['class' => 'text-white bg-custom-black py-[5px] px-4 font-normal text-base text-center rounded-md hover:bg-white hover:text-dark-orange border border-black hover:border-dark-orange transition-colors']) }}>
    {{ $slot }}
</button>
