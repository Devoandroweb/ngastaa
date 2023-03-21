import { Inertia } from '@inertiajs/inertia';
import React from 'react'
import Swal from 'sweetalert2';

export default function Approved({ routes }) {

    const handleClick = () => {
        Swal.fire({
            title: 'Apakah anda yakin menerima data ini?',
            text: "Mohon diperhatikan kembali!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.isConfirmed) {
                Inertia.get(routes);
            }
        })
    }
    return (
        <div className="dropdown-item  menu-item px-3">
            <a href="#" onClick={() => handleClick()} className="menu-link px-3"><i className='fa fa-check mr-2 text-success'></i> Terima </a>
        </div>
    )
}
