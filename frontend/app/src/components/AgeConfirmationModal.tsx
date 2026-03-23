type Props = {
    onConfirm: () => void;
    onCancel: () => void;
}

const AgeConfirmationModal = ({onConfirm, onCancel}: Props) => {
    return ( 
        <>
            <div
                className="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent"
                role="dialog"
                aria-modal="true"
            >
                <div
                    className="fixed inset-0 bg-gray-500/75 transition-all"
                    onClick={onCancel}
                ></div>

                <div
                    className="flex min-h-full items-center justify-center p-4 text-center"
                    onClick={e => e.stopPropagation()}
                >
                    <div className="relative w-full max-w-3xl mx-auto transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all">
                    
                        <div className="bg-neutral-100 p-6 md:p-10 flex flex-col items-center">
                            
                            <div className="w-full max-w-xl text-left text-sm text-neutral-500">
                            <p>有効にすると、成人向け作品を含む検索結果が表示されます。18歳未満の方のアクセスは固くお断りします。</p>
                            </div>
                            
                            <div className="md:flex md:items-start mt-4 mb-3 text-center">
                            <h3 className="text-lg font-semibold text-pink-700">あなたは18歳以上ですか？</h3>
                            </div>
                            
                            <div className="flex flex-col md:flex-row justify-center gap-[1rem] md:gap-[2rem] w-full">
                            <div className="inline-flex w-full md:w-[240px] justify-center">
                                <button
                                    className="rounded-full min-h-[40px] w-full bg-pink-700 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-pink-800 active:bg-pink-600 hover:cursor-pointer"
                                    onClick={onConfirm}
                                >
                                    はい
                                </button>
                            </div>
                            <div className="inline-flex w-full md:w-[240px] justify-center">
                                <button
                                    className="rounded-full min-h-[40px] w-full bg-neutral-100 px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-stone-300 hover:inset-ring-blue-700 active:hover:inset-ring-blue-700 hover:cursor-pointer"
                                    onClick={onCancel}
                                >
                                    いいえ
                                </button>
                            </div>
                            </div>
                            
                        </div>
                    
                    </div>
                    
                </div>
                
            </div>
        </>
    );
}

export default AgeConfirmationModal;