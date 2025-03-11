import { Link } from 'react-router-dom';
import { useTranslation } from 'react-i18next'; 

export default function Home() {
    const { t } = useTranslation(['common']); 

    return (
        <div>
            <h1 className="mt-16 mb-10 text-xl font-semibold text-center">{t('common:not_found_404')}</h1>
            <Link to="/" className="text-gray-500 hover:text-orange-500">{t('common:back_to_home')}</Link>
        </div>
    );
}