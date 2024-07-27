<script lang="ts" setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import { DayOffResourceInterface } from '@/types/DayOffRequest/DayOffResourceInterface';
import DisplayInformation from '@/Components/DisplayComponents/DisplayInformation.vue';
import InformationItem from '@/Components/DisplayComponents/InformationItem.vue';
import StatusModal from './StatusModal.vue'
import { Ref,ref } from 'vue';
import IconButton from '@/Components/IconButton.vue';
import { faFileCircleCheck } from '@fortawesome/free-solid-svg-icons';
const props=defineProps<{
    breadcrumbs:BreadcrumbsInterface[],
    offRequest:DayOffResourceInterface
}>()

const OpenDialog : Ref<boolean>=ref(false)

</script>
<template>
    <MainLayout head="Request Information" :breadcrumbs="breadcrumbs">
        <DisplayInformation>
            <template #mainLabel>
                {{offRequest.data.label}}
            </template>
            <template #mainDescription>
                {{offRequest.data.description}}
            </template>
            <template #items>
                <InformationItem>
                    <template #label>Date</template>
                    <template #value>{{offRequest.data.created_at}}</template>
                </InformationItem>
                <InformationItem>
                    <template #label>Employee</template>
                    <template #value>{{offRequest.data.user.name}}</template>
                </InformationItem>
                <InformationItem>
                    <template #label>label</template>
                    <template #value>
                        {{offRequest.data.label}}
                    </template>
                </InformationItem>
                <InformationItem >
                    <template #label>Status</template>
                    <template #value >
                        <div class="flex justify-between">
                            <p :class="{'text-orange-500':offRequest.data.status=='Pending',
                                    'text-danger':offRequest.data.status=='Refused',
                                    'text-success':offRequest.data.status=='Accepted'}" >
                            {{$helpers.capitalizeFirstLetter(offRequest.data.status)}}
                            </p>
                            <div> <IconButton v-if="$helpers.hasRole('HR')" type="change" label="Change Status" @click="OpenDialog=!OpenDialog" /> </div>
                        </div>
                    </template>
                </InformationItem>
                <InformationItem class="col-span-2">
                    <template #label>Description</template>
                    <template #value>{{offRequest.data.description}}</template>
                </InformationItem>
                <InformationItem>
                    <template #label>Duration</template>
                    <template #value>{{offRequest.data.duration}}</template>
                </InformationItem>
                <InformationItem>
                    <template #label>Type of justification</template>
                    <template #value>{{offRequest.data.type}}</template>
                </InformationItem>
                <InformationItem class="col-span-2">
                    <template #label>Justifications</template>
                    <template #value>
                        <div v-if="typeof offRequest.data.justification === 'string'">
                            <p>{{ offRequest.data.justification }}</p>
                        </div>
                        <div v-else>
                            <div v-for="(item,idx) in offRequest.data.justification" class="p-2 hover:bg-primary hover:bg-opacity-5">
                                <a :href="(item as unknown as string)" target="_blank">
                                    <faIcon class="text-success mr-2" :icon="faFileCircleCheck" />
                                    <span class="text-stroke">Justification-{{ idx }}.{{ (item as unknown as string).substring((item as unknown as string).lastIndexOf('.') + 1) }}</span>

                                </a>
                            </div>
                        </div>
                    </template>
                </InformationItem>
                <InformationItem v-if="offRequest.data.status_answer" class="col-span-2">
                    <template #label>HR Message</template>
                    <template #value>{{offRequest.data.status_answer}}</template>
                </InformationItem>

            </template>
        </DisplayInformation>
        <StatusModal :isOpen="OpenDialog" :off_request="offRequest" @close="OpenDialog=false"/>
    </MainLayout>
</template>
