<?php

namespace App\Livewire;

use App\Models\RegistrationKey;
use Livewire\Component;
use Livewire\WithPagination;

use function Ramsey\Uuid\v4;

class RegistrationKeyView extends Component
{
    use WithPagination;

    public int $numberOfKeys = 1;
    public string $status = "unused";
    public string $search = '';

    public function deleteKey(RegistrationKey $key)
    {
        $key->delete();
    }

    public function copyKey($key)
    {
        $this->dispatch('copyKey', $key);
    }

    public function generateKeys()
    {
        for ($i = 0; $i < $this->numberOfKeys; $i++) {
            $key = new RegistrationKey();

            $key->key_string = v4();

            $key->save();
        }
    }

    public function render()
    {
        $keys = RegistrationKey::query();

        if ($this->status === 'used') {
            $keys = $keys->whereHas('usage');
        } elseif ($this->status === 'unused') {
            $keys = $keys->doesntHave('usage');
        }

        return view('livewire.registration-key-view')
            ->with(
                'keys',
                $keys->paginate(4)
            );
    }
}
