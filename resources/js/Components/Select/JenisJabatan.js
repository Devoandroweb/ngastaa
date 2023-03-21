import React from 'react'
import Select from 'react-select'

export default function JenisJabatan({ onchangeHandle, valueHandle }) {

    const options = [
        { value : '1', jenis_jabatan: '1', label: 'Struktural' },
        { value : '2', jenis_jabatan: '2', label: 'Fungsional' },
        { value : '4', jenis_jabatan: '4', label: 'Pelaksana' }
    ]

  return (
    <Select options={options} className="z-50" onChange={onchangeHandle} value={options.filter(obj => (obj.jenis_jabatan == valueHandle))} />
  )
}
