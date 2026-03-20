type Props = {
    message: string
}

const ErrorMessage = ({ message }: Props) => 
    <div className="mt-6">
        <p className="text-red-500">{message}</p>
    </div>;

export default ErrorMessage;