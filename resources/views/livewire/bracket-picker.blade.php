<div x-data="{}">
    <x-tournament.bracket :bracket="$uiBracket" :canPick="true">
        <x-slot:header>
            <x-tournament.header.picking :bracket="$uiBracket"/>
        </x-slot:header>
    </x-tournament.bracket>
</div>
