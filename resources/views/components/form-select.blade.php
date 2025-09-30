<div class="mb-4">
    <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1" for="{{ $name }}">
        {{ $label }}
    </label>
    <select class="form-select w-full px-4 py-3 bg-slate-100 dark:bg-border-dark/30 border border-slate-200 dark:border-slate-700 rounded-lg text-lg text-slate-800 dark:text-slate-200 focus:ring-primary focus:border-primary transition-shadow" id="{{ $name }}" name="{{ $name }}">
        @foreach($options as $value => $text)
            <x-form-option :value="$value" :text="$text" :name="$name" :selected="$selected" />
        @endforeach
    </select>
</div>