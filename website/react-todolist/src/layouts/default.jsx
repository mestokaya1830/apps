import { Outlet } from 'react-router-dom'

export default function Default() {
  return (
    <div>
      <main className='router'>
        <Outlet />
      </main>
    </div>
  )
}
