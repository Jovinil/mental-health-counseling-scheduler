<div class="flex flex-col bg-accent">
    <div class="bg-gray-100 rounded-t-lg p-4 text-white border-b border-b-gray-400">
        <h1 class=" text-xl text-accent font-bold">Session Details</h1>
        <p class="text-gray-200 font-thin">Please provide your information and preferences</p>
    </div>

    <div class="flex flex-col gap-3 bg-gray-50 rounded-b-lg p-4">
        <h2>Personal Information</h2>

        <div>
            <flux:field>
                <flux:label>Full Name *</flux:label>

                <flux:input />

                <flux:error name="fullname" />
            </flux:field>
        </div>

        <div>
            <flux:field>
                <flux:label>Email *</flux:label>

                <flux:input />

                <flux:error name="email" />
            </flux:field>
        </div>

        <div>
            <flux:field>
                <flux:label>Phone Number *</flux:label>

                <flux:input />

                <flux:error name="phone" />
            </flux:field>
        </div>

        <x-divider />

        <h2>Session Preferences</h2>
        <div class="w-full">
            <flux:label>Counselor *</flux:label>
            <flux:dropdown position="bottom" align="start" class="w-full!">

                    <flux:button icon:trailing="chevron-down" class="w-full flex text-start justify-between!">Counselor</flux:button>

                    <flux:menu>
                        <flux:menu.item icon="plus">New post</flux:menu.item>
                        <flux:menu.item variant="danger" icon="trash">Delete</flux:menu.item>
                        <flux:menu.item icon="plus">New post</flux:menu.item>
                        <flux:menu.item variant="danger" icon="trash">Delete</flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
        </div>

        <div class="w-full">
            <flux:label>Session *</flux:label>
           <flux:dropdown position="bottom" align="start" class="w-full!">

                <flux:button icon:trailing="chevron-down" class="w-full flex text-start justify-between!">Session</flux:button>

                <flux:menu>
                    <flux:menu.item icon="plus">New post</flux:menu.item>
                    <flux:menu.item variant="danger" icon="trash">Delete</flux:menu.item>
                    <flux:menu.item icon="plus">New post</flux:menu.item>
                    <flux:menu.item variant="danger" icon="trash">Delete</flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </div>

        <div class="w-full flex gap-6">
            <x-date-picker label="Preferred Date" name="session_date" />
            <x-time-dropdown :times="['08:00 AM', '09:30 AM', '01:30 PM']" label="Preferred Time" name="session_time" />
        </div>

        <x-divider />

        <h2>Additional Information</h2>
        <div>
            <flux:label>Notes or Concerns (Optional) *</flux:label>
            <flux:textarea placeholder="Share any specific concerns or topics you'd like to discuss..." />
        </div>
    </div>
</div>
